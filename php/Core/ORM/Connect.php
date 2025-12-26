<?php

namespace Core\ORM;


use PDO;

class Connect
{
    private static $pdo;

    public static function connection()
    {

        if (!self::$pdo) {
            self::$pdo = new PDO(
                "mysql:host=db;dbname=emes",
                "root",
                "",
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        }

        return self::$pdo;
    }
}
