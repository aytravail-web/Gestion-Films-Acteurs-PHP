<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\People;
use PDO;

class PeopleCollection
{
    /**
     *  Récupère toutes les personnes associées à un film spécifique.
     * @param int $idMovie L'identifiant unique du film
     * @return People[]
     */
    public static function findByMovieId(int $idMovie): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            'SELECT p.id, p.name, p.birthday, p.deathday, p.placeOfBirth, p.biography, p.avatarId, c.role
            FROM people p
            INNER JOIN cast c ON p.id = c.peopleId
            WHERE c.movieId = :idMovie'
        );
        $stmt->execute([
            'idMovie' => $idMovie
        ]);

        return $stmt->fetchAll(
            PDO::FETCH_CLASS,
            People::class
        );
    }

}
