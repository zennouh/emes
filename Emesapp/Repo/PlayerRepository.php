<?php

namespace Repo;

class PlayerRepository extends BaseRepository
{
    protected string $table = 'players';

    public function create(
        int $teamId,
        string $pseudo,
        string $role,
        int $salary
    ): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO players (teamId, pseudo, role, salary)
             VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$teamId, $pseudo, $role, $salary]);
    }

    public function update(int $id, string $pseudo, string $role, int $salary): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE players SET pseudo=?, role=?, salary=? WHERE id=?"
        );
        return $stmt->execute([$pseudo, $role, $salary, $id]);
    }
}
