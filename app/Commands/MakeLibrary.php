<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Config\Services;
use CodeIgniter\Files\File;

class MakeLibrary extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'make:library';
    protected $description = 'Creates a new library in the app/Libraries directory';

    public function run(array $params)
    {
        // Get the library name from the arguments
        $libraryName = $params[0] ?? null;

        if (is_null($libraryName)) {
            CLI::error('You must specify a library name.');
            return;
        }

        $libraryPath = APPPATH . 'Libraries/' . $libraryName . '.php';

        // Check if the file already exists
        if (file_exists($libraryPath)) {
            CLI::error("Library {$libraryName} already exists.");
            return;
        }

        // Create the library file
        $this->createLibraryFile($libraryName);
    }

    private function createLibraryFile($libraryName)
    {
        $stub = "<?php\n\nnamespace App\\Libraries;\n\nclass {$libraryName}\n{\n    // Your code here\n}\n";

        // Create the library file
        $libraryPath = APPPATH . 'Libraries/' . $libraryName . '.php';
        file_put_contents($libraryPath, $stub);

        CLI::write("Library {$libraryName} created successfully.", 'green');
    }
}