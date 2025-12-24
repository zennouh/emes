<?php

namespace Core\Console\Commands;

use Core\ORM\Migration\Handler\Handler;
use Exception;

class MigrateCommand
{
    public function handle(): void
    {
        echo "Running migrations...\n";
        // 1️⃣ كل الـ Entities
        $entitiesPath = __DIR__ . '/Models';
        $files = glob($entitiesPath . '/*.php');

        // 2️⃣ Handler
        $handler = new Handler();

        // 3️⃣ Loop على كل Entity
        foreach ($files as $file) {
            require_once $file;

            // اسم الكلاس من اسم الملف
            $className = 'Models\\' . basename($file, '.php');

            echo "Migrating: $className\n";

            try {
                $sql = $handler->generate($className);
                echo $sql . "\n\n";

                // هنا يمكنك تنفيذ SQL (PDO)
            } catch (Exception $e) {
                echo "❌ Error: " . $e->getMessage() . "\n";
            }
        }

        echo "Done ✅\n";
    }
}
