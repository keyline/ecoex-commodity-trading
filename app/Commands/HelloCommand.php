<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class HelloCommand extends BaseCommand
{
    protected $group       = 'custom';
    protected $name        = 'hello';
    protected $description = 'Prints Hello message with a name';

    public function run(array $params)
    {
        $name = $params[0] ?? 'World';
        CLI::write("Hello, {$name}!", 'green');
    }
}
