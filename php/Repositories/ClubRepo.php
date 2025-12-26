<?php

use Core\ORM\Connect;
use Core\ORM\EntityManager;

#[Club]
class ClubRepo extends EntityManager
{

    public function create($name, $city)
    {
        Connect::connection()->prepare(
            "INSERT INTO clubs (name, city) VALUES (?, ?)"
        )->execute([$name, $city]);
    }

    public function all()
    {
        return Connect::connection()
            ->query("SELECT * FROM clubs")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $city)
    {
        Connect::connection()->prepare(
            "UPDATE clubs SET name=?, city=? WHERE id=?"
        )->execute([$name, $city, $id]);
    }

    public function delete($id)
    {
       Connect::connection()->prepare(
            "DELETE FROM clubs WHERE id=?"
        )->execute([$id]);
    }
}
