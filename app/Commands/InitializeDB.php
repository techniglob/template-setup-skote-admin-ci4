<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class InitializeDB extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'default';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'initializeDB';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Initializes the database by running all migrations and seeders within a transaction.';

    /** @var ConnectionInterface */
    protected $db;

    public function __construct()
    {
        parent::__construct();
        // Get the database connection
        $this->db = \Config\Database::connect();
    }

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        CLI::write('🔁 Starting database initialization...', 'yellow'); 
        
        // Start a transaction
        $this->db->transBegin();

        try {
            // Run migrations
            CLI::write('Running migrations...', 'yellow');
            $runner = service('migrations');
            $runner->setGroup('default'); // Specify the database group if needed
            $runner->latest('default'); // Run all migrations in the default group
            CLI::write('✅ Migrations completed successfully.', 'green');

            // Run all seeders
            CLI::write('🔁 Running all seeders...', 'yellow');
            $seederFiles = $this->getSeederFiles();

            if (empty($seederFiles)) {
                CLI::write('❌ No seeders found.', 'yellow');
            } else {
                $seeder = \Config\Database::seeder();
                foreach ($seederFiles as $file) {
                    $seederName = $this->getSeederName($file);
                    CLI::write(" 🔁Running seeder: {$seederName}...", 'yellow');
                    $seeder->call($seederName);
                    CLI::write("✅ Seeder {$seederName} completed successfully.", 'green');
                }
            }

            // Commit the transaction
            if ($this->db->transStatus() === false) {
                throw new \RuntimeException('❌ Transaction failed due to database errors.', 'red');
            }

            $this->db->transCommit();
            CLI::write('✅ Database initialization completed successfully!', 'green');
        } catch (\Throwable $e) {
            // Rollback the transaction on error
            $this->db->transRollback();
            CLI::error('❌ Database initialization failed: ' . $e->getMessage());
            return;
        }
    }
}
