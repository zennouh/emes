<?php

namespace Repo;

class TournamentRepository extends BaseRepository
{
    protected string $table = 'tournaments';

    public function create(
        string $title,
        int $cashPrize,
        string $format,
        string $date
    ): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO tournaments (title, cashPrize, format, date)
             VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$title, $cashPrize, $format, $date]);
    }

    public function update(
        int $id,
        string $title,
        int $cashPrize,
        string $format,
        string $date
    ): bool {
        $stmt = $this->db->prepare(
            "UPDATE tournaments
             SET title=?, cashPrize=?, format=?, date=?
             WHERE id=?"
        );
        return $stmt->execute([$title, $cashPrize, $format, $date, $id]);
    }
}
