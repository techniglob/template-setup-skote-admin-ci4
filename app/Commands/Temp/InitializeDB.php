<?php
namespace App\Commands\Temp;

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

    protected $db;
    protected $runner;

    public function __construct(LoggerInterface $logger, Commands $commands)
    {
        parent::__construct($logger, $commands);
        $this->db = \Config\Database::connect();
        $this->runner = service('migrations');
        $this->runner->setGroup('default');
        $this->runner->ensureTable();
    }

    public function run(array $params)
    {
        $lockFile = WRITEPATH . 'db_init.lock';
        if (file_exists($lockFile)) {
            // CLI::write('Database has already been initialized. To run again, delete: ' . $lockFile, 'light_red');
            CLI::write('Database has already been initialized. ', 'light_red');
            return;
        }

        CLI::write('Starting database initialization...', 'yellow');

        $appliedMigrations = [];

        try {
            // Run migrations
            CLI::write('Running migrations...', 'yellow');
            $migrations = $this->runner->findMigrations();
            $appliedVersions = $this->getAppliedMigrations();
            $pending = array_filter($migrations, fn($migration) => !in_array($migration->version, $appliedVersions));

            if (empty($pending)) {
                CLI::write('No pending migrations.', 'yellow');
            } else {
                uasort($pending, fn($a, $b) => strcmp($a->version, $b->version));
                foreach ($pending as $migration) {
                    $migrationName = $this->getMigrationName($migration);
                    CLI::write("Running migration: {$migrationName}...", 'yellow');

                    $migrationInstance = $this->instantiateMigration($migration);
                    $migrationInstance->up();

                    $this->db->table('migrations')->insert([
                        'version'   => $migration->version,
                        'class'     => $migration->name,
                        'group'     => 'default',
                        'namespace' => $migration->namespace,
                        'time'      => time(),
                    ]);
                    $appliedMigrations[] = ['instance' => $migrationInstance, 'version' => $migration->version, 'name' => $migrationName];
                    CLI::write("Migration {$migrationName} completed successfully.", 'green');
                }
            }
            CLI::write('All migrations completed successfully.', 'green');

            // Seeders
            CLI::write('Starting transaction for seeders...', 'yellow');
            $this->db->transBegin();
            CLI::write('Transaction status: ' . ($this->db->transStatus() ? 'Active' : 'Inactive'), 'yellow');

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

            if ($this->db->transStatus() === false) {
                throw new \RuntimeException('Transaction failed due to database errors.');
            }

            $this->db->transCommit();
            CLI::write('Transaction committed successfully.', 'green');
            CLI::write('Database initialization completed successfully!', 'green');

            // Create lock file
            file_put_contents($lockFile, 'initialized');
            CLI::write("Lock file created: {$lockFile}", 'light_gray');
        } catch (\Throwable $e) {
            $db = \Config\Database::connect();
            if ($db->tableExists('migrations')) {
                $db->query("DROP TABLE `migrations`");
            }

            if (!empty($appliedMigrations)) {
                CLI::write('Rolling back migrations...', 'yellow');
                foreach (array_reverse($appliedMigrations) as $migration) {
                    $migrationName = $migration['name'];
                    CLI::write("Rolling back migration: {$migrationName}...", 'yellow');
                    $migration['instance']->down();
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

    protected function instantiateMigration(object $migration): \CodeIgniter\Database\Migration
    {
        if (!file_exists($migration->path)) {
            throw new \RuntimeException("Migration file not found: {$migration->path}");
        }

        require_once $migration->path;
        $className = $migration->namespace . '\\Database\\Migrations\\' . $migration->name;

        if (!class_exists($className, false)) {
            throw new \RuntimeException("Migration class not found: {$className}");
        }

        $migrationInstance = new $className($this->forge);
        if (!($migrationInstance instanceof \CodeIgniter\Database\Migration)) {
            throw new \RuntimeException("Class {$className} is not a valid migration.");
        }

        return $migrationInstance;
    }

    protected function getSeederFiles(): array
    {
        $path = APPPATH . 'Database/Seeds/';
        $files = glob($path . '*.php');
        return array_filter($files, function ($file) {
            return basename($file) !== 'index.php';
        });
    }

    protected function getSeederName(string $file): string
    {
        return basename($file, '.php');
    }

    protected function getMigrationName(object $migration): string
    {
        return $migration->name ?? basename($migration->path, '.php');
    }

    protected function getAppliedMigrations(): array
    {
        if (!$this->db->tableExists('migrations')) {
            return [];
        }

        $query = $this->db->table('migrations')->select('version')->get();
        return array_column($query->getResultArray(), 'version');
    }
}
