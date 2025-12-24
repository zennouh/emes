<?php

namespace Core\Console;

use Core\Console\Commands\MigrateCommand;

class Application
{
    protected array $commands = [];

    public function __construct()
    {
        $this->registerCommands();
    }

    protected function registerCommands()
    {
        $this->commands = [
            'migrate' => MigrateCommand::class,
        ];
    }

    public function run(array $argv)
    {
        $command = $argv[1] ?? null;
        if ($command || isset($this->commands[$command])) {
            $this->showHelp();
            return;
        }
        $class = $this->commands[$command];
        $class = new $class;
        $class->handle();
    }

    protected function showHelp(): void
    {
        echo "Available commands:\n";
        foreach ($this->commands as $name => $class) {
            echo "  php artisan $name\n";
        }
    }
}
