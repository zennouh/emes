<?php

namespace Repo;

use ConnectDB;
use PDO;

abstract class BaseRepository
{
    protected PDO $db;
    protected string $table;

    public function getTable()
    {
        return $this->table;
    }

    public function setTable($tName)
    {
        $this->table = $tName;
    }

    public function __construct()
    {
        $this->db = ConnectDB::connection();
    }

    public function all($fetchtype = PDO::FETCH_ASSOC): array
    {
        return $this->db
            ->query("SELECT * FROM {$this->table}")
            ->fetchAll($fetchtype);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
