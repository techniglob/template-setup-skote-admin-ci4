<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Database\MigrationRunner;
use CodeIgniter\Files\FileCollection;

class DatabaseInit extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'db:init';
    protected $description = 'Initializes the database by running all migrations and all seeders within a transaction.';

    /** @var ConnectionInterface */
    protected $db;

    public function __construct()
    {
        parent::__construct();
        // Get the database connection
        $this->db = \Config\Database::connect();
    }

    public function run(array $params)
    {
        CLI::write('Starting database initialization...', 'yellow');

        // Start a transaction
        $this->db->transBegin();

        try {
            // Run migrations
            CLI::write('Running migrations...', 'yellow');
            $runner = service('migrations');
            $runner->setGroup('default'); // Specify the database group if needed
            $runner->latest('default'); // Run all migrations in the default group
            CLI::write('Migrations completed successfully.', 'green');

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

            // Commit the transaction
            if ($this->db->transStatus() === false) {
                throw new \RuntimeException('Transaction failed due to database errors.');
            }

            $this->db->transCommit();
            CLI::write('Database initialization completed successfully!', 'green');
        } catch (\Throwable $e) {
            // Rollback the transaction on error
            $this->db->transRollback();
            CLI::error('Database initialization failed: ' . $e->getMessage());
            return;
        }
    }

    /**
     * Get all seeder files from the Seeds directory.
     *
     * @return array
     */
    protected function getSeederFiles(): array
    {
        $path = APPPATH . 'Database/Seeds/';
        $files = (new FileCollection())->get($path . '*.php');
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
}