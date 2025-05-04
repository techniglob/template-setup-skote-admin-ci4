<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Database\MigrationRunner;
use Psr\Log\LoggerInterface;
use CodeIgniter\CLI\Commands;

class InitializeDB extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'db:init';
    protected $description = 'Initializes the database by running all migrations and seeders, rolling back all changes on error.';

    /**
     * Database connection
     * @var \CodeIgniter\Database\BaseConnection|ConnectionInterface
     */
    protected $db;

    /**
     * Migration runner
     * @var MigrationRunner
     */
    protected $runner;

    public function __construct(LoggerInterface $logger, Commands $commands)
    {
        parent::__construct($logger, $commands);
        // Get the database connection
        $this->db = \Config\Database::connect();
        // Get the migration runner
        $this->runner = service('migrations');
        $this->runner->setGroup('default');
        $this->runner->ensureTable();
        // getPrint($this->runner);
    }

    public function run(array $params)
    {
        CLI::write('Starting database initialization...', 'yellow');

        // Track applied migrations for rollback
        $appliedMigrations = [];

        try {
            // Run migrations individually
            CLI::write('Running migrations...', 'yellow');
            $migrations = $this->runner->findMigrations();
            $appliedVersions = $this->getAppliedMigrations();
            $pending = array_filter($migrations, fn($migration) => !in_array($migration->version, $appliedVersions));

            if (empty($pending)) {
                CLI::write('No pending migrations.', 'yellow');
            } else {
                // Sort migrations by version
                uasort($pending, fn($a, $b) => strcmp($a->version, $b->version));
                foreach ($pending as $migration) {
                    $migrationName = $this->getMigrationName($migration);
                    CLI::write("Running migration: {$migrationName}...", 'yellow');

                    // Instantiate the migration class
                    $migrationInstance = $this->instantiateMigration($migration);
                    // Run the migration's up() method
                    $migrationInstance->up();
                    // Record the migration in the migrations table
                    $this->db->table('migrations')->insert([
                        'version' => $migration->version,
                        'class'   => $migration->name,
                        'group'   => 'default',
                        'namespace' => $migration->namespace,
                        'time'    => time(),
                    ]);
                    $appliedMigrations[] = ['instance' => $migrationInstance, 'version' => $migration->version, 'name' => $migrationName];
                    CLI::write("Migration {$migrationName} completed successfully.", 'green');
                }
            }
            CLI::write('All migrations completed successfully.', 'green');

            // Start transaction for seeders
            CLI::write('Starting transaction for seeders...', 'yellow');
            $this->db->transBegin();
            CLI::write('Transaction status: ' . ($this->db->transStatus() ? 'Active' : 'Inactive'), 'yellow');

            // Run all seeders
            CLI::write('Running all seeders...', 'yellow');
            $seederFiles = $this->getSeederFiles();

            if (empty($seederFiles)) {
                CLI::write('No seeders found.', 'yellow');
            } else {
                $seeder = \Config\Database::seeder();
                foreach ($seederFiles as $file) {
                    $seederName = $this->getSeederName($file);
                    CLI::write("Running seeder: {$seederName}...", 'yellow');
                    $seeder->call($seederName);
                    CLI::write("Seeder {$seederName} completed successfully.", 'green');
                }
            }

            // Check transaction status before commit
            if ($this->db->transStatus() === false) {
                throw new \RuntimeException('Transaction failed due to database errors.');
            }

            // Commit the transaction
            CLI::write('Committing transaction...', 'yellow');
            $this->db->transCommit();
            CLI::write('Transaction committed successfully.', 'green');
            CLI::write('Database initialization completed successfully!', 'green');
            // Delete the command file
            $commandFile = __FILE__;
            if (file_exists($commandFile)) {
                unlink($commandFile);
                CLI::write("Command file '{$this->name}' deleted successfully.", 'light_gray');
            }
        } catch (\Throwable $e) {
            $db = \Config\Database::connect();
            // Check if the migrations table exists
            if ($db->tableExists('migrations')) {
                $db->query("DROP TABLE `migrations`");
            }
            // Rollback migrations
            if (!empty($appliedMigrations)) {
                CLI::write('Rolling back migrations...', 'yellow');
                // Reverse migrations in reverse order
                foreach (array_reverse($appliedMigrations) as $migration) {
                    $migrationName = $migration['name'];
                    CLI::write("Rolling back migration: {$migrationName}...", 'yellow');
                    $migration['instance']->down();
                    // Remove from migrations table
                    $this->db->table('migrations')->where('version', $migration['version'])->delete();
                    CLI::write("Migration {$migrationName} rolled back successfully.", 'green');
                }
            }

            CLI::error('Database initialization failed: ' . $e->getMessage());
            CLI::error('All changes (migrations and seeders) have been rolled back.');
            CLI::error('Ensure all tables use the InnoDB engine for seeder transaction support.');
            return;
        }
    }

    /**
     * Instantiate a migration class from its metadata.
     *
     * @param object $migration
     * @return \CodeIgniter\Database\Migration
     * @throws \RuntimeException
     */
    protected function instantiateMigration(object $migration): \CodeIgniter\Database\Migration
    {
        // Ensure the migration file exists
        
        if (!file_exists($migration->path)) {
            throw new \RuntimeException("Migration file not found: {$migration->path}");
        }

        // Include the migration file
        require_once $migration->path;

        // Construct the full class name
        $className = $migration->namespace . '\\Database\\Migrations\\' . $migration->name;
        // $className = $migration;
        // getPrint($className);
        // Check if the class exists
        if (!class_exists($className, false)) {
            throw new \RuntimeException("Migration class not found: {$className}");
        }

        // Instantiate the migration class
        $migrationInstance = new $className($this->forge);
        // getPrint($migrationInstclsance);
        // Verify it's a valid migration
        if (!($migrationInstance instanceof \CodeIgniter\Database\Migration)) {
            throw new \RuntimeException("Class {$className} is not a valid migration.");
        }

        return $migrationInstance;
    }

    /**
     * Get all seeder files from the Seeds directory.
     *
     * @return array
     */
    protected function getSeederFiles(): array
    {
        $path = APPPATH . 'Database/Seeds/';
        $files = glob($path . '*.php');
        return array_filter($files, function ($file) {
            // Exclude non-seeder files (e.g., index.php or non-PHP files)
            return basename($file) !== 'index.php';
        });
    }

    /**
     * Extract the seeder class name from the file path.
     *
     * @param string $file
     * @return string
     */
    protected function getSeederName(string $file): string
    {
        // Get the base name without the .php extension
        return basename($file, '.php');
    }

    /**
     * Get the migration name or file path for display.
     *
     * @param object $migration
     * @return string
     */
    protected function getMigrationName(object $migration): string
    {
        // Extract the class name or file path from the migration object
        return $migration->name ?? basename($migration->path, '.php');
    }

    /**
     * Get the versions of applied migrations from the migrations table.
     *
     * @return array
     */
    protected function getAppliedMigrations(): array
    {
        // Check if the migrations table exists
        if (!$this->db->tableExists('migrations')) {
            return [];
        }

        // Query the migrations table for applied versions
        $query = $this->db->table('migrations')->select('version')->get();
        return array_column($query->getResultArray(), 'version');
    }
}