<?php

namespace Repo;

class ClubRepository extends BaseRepository
{
    protected string $table = 'clubs';

    public function create(string $name, string $city): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO clubs (name, city) VALUES (?, ?)"
        );
        return $stmt->execute([$name, $city]);
    }

    public function update(int $id, string $name, string $city): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE clubs SET name = ?, city = ? WHERE id = ?"
        );
        return $stmt->execute([$name, $city, $id]);
    }
}
