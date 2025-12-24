<?php

namespace Core\ORM\Migration\Handler;

use Core\Database\Migration\ForeignKey;
use Core\Database\Migration\Table;
use Core\ORM\Migration\Attributes\Column;
use Core\ORM\Migration\Constrains\AutoIncrement;
use Core\ORM\Migration\Constrains\Defaulte;
use Core\ORM\Migration\Constrains\Id;
use Core\ORM\Migration\Constrains\TimeStamp;
use Exception;
use ReflectionClass;


class Handler
{
    public function generate(string $className): string
    {
        $ref = new ReflectionClass($className);

        // Table name
        $tableAttr = $ref->getAttributes(Table::class)[0] ?? null;
        if (!$tableAttr) {
            throw new Exception("Table attribute missing");
        }

        $table = $tableAttr->newInstance()->name;
        $columns = [];
        $foreignKeys = [];


        foreach ($ref->getProperties() as $prop) {
            $sql = $this->handleProperty($prop);
            if ($sql) {
                $columns[] = $sql;
            }

            $fk = $this->handleForeignKey($prop);
            if ($fk) {
                $foreignKeys[] = $fk;
            }
        }

        return "CREATE TABLE $table (\n" .
            implode(",\n", array_merge($columns, $foreignKeys)) .
            "\n);";
    }

    private function handleProperty($prop): ?string
    {
        $colAttr = $prop->getAttributes(Column::class)[0] ?? null;
        if (!$colAttr) {
            return null;
        }

        $column = $colAttr->newInstance();
        $name = $prop->getName();

        $type = $this->mapType($prop);
        
        if ($prop->getAttributes(TimeStamp::class)) {
            $type = 'TIMESTAMP';
        }

        $sql = "$name $type";



        if ($prop->getAttributes(Id::class)) {
            $sql .= " PRIMARY KEY";
        } else {
            if (!$column->nullable) {
                $sql .= " NOT NULL";
            }

            if ($column->unique) {
                $sql .= " UNIQUE";
            }
        }

        if ($prop->getAttributes(AutoIncrement::class)) {
            $sql .= " AUTO_INCREMENT";
        }

        if ($def = $prop->getAttributes(Defaulte::class)[0] ?? null) {
            $sql .= " DEFAULT " . $def->newInstance()->value;
        }

        return $sql;
    }

    private function mapType($prop): string
    {
        return match ((string)$prop->getType()) {
            'int' => 'INT',
            'float' => 'FLOAT',
            'string' => 'VARCHAR(255)',
            default => 'TEXT',
        };
    }
    private function handleForeignKey($prop): ?string
    {
        $fkAttr = $prop->getAttributes(ForeignKey::class)[0] ?? null;

        if (!$fkAttr) {
            return null;
        }

        $fk = $fkAttr->newInstance();
        $column = $prop->getName();

        return "FOREIGN KEY ($column) 
            REFERENCES {$fk->reference}({$fk->colmun})
            ON DELETE {$fk->delete}
            ON UPDATE {$fk->update}";
    }
}
