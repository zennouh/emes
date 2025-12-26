<?php

namespace Repo;

class TeamRepository extends BaseRepository
{
    protected string $table = 'teams';

    public function create(int $clubId, string $name, string $game): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO teams (clubId, name, game) VALUES (?, ?, ?)"
        );
        return $stmt->execute([$clubId, $name, $game]);
    }

    public function update(int $id, string $name, string $game): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE teams SET name = ?, game = ? WHERE id = ?"
        );
        return $stmt->execute([$name, $game, $id]);
    }
}
