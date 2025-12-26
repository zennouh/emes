<?php

namespace Core\Console\Commands;

require_once "Core/ORM/Migration/Handler/Handler.php";

use Core\ORM\Migration\Handler\Handler;
use Exception;

class MigrateCommand
{
    public function handle(): void
    {
        echo "Running migrations...\n";
        $entitiesPath = "/app" . '/Models';
        
        $files = glob($entitiesPath . '/*.php');
      
        $handler = new Handler();
        foreach ($files as $file) {
            require_once $file;

            // $className = 'Models\\' . basename($file, '.php');
            $className = basename($file, '.php');

           

            try {
                $sql = $handler->generate($className);
                echo $sql . "\n\n";
            } catch (Exception $e) {
                echo "❌ Error: " . $e->getMessage() . "\n";
            }
        }

        echo "Done\n";
    }
}
