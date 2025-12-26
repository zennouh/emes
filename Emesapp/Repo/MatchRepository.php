<?php

namespace Repo;

class MatchRepository extends BaseRepository
{
    protected string $table = 'matches';

    public function create(
        int $scoreA,
        int $scoreB,
        int $tournamentId,
        int $teamA,
        int $teamB,
        ?int $winnerId,
        string $format,
        string $date
    ): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO matches
            (score_a, score_b, tournamentId, team_a, team_b, winnerId, format, date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        return $stmt->execute([
            $scoreA,
            $scoreB,
            $tournamentId,
            $teamA,
            $teamB,
            $winnerId,
            $format,
            $date
        ]);
    }
}
