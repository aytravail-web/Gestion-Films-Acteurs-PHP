<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Cast
{
    private int $movieId;
    private int $peopleId;
    private ?string $role = null;
    private int $orderIndex;
    private ?int $id = null;

    /**
     * Récupère le rôle d'une personne dans un film spécifique.
     * @param int $peopleId L'identifiant unique de la personne
     * @param int $movieId L'identifiant unique du film
     * @return string|null
     */
    public static function findRoleByPeopleAndMovie(int $peopleId, int $movieId): ?string
    {
        $stmt = MyPdo::getInstance()->prepare(
            'SELECT role
        FROM cast
        WHERE peopleId = :peopleId
        AND movieId = :movieId'
        );
        $stmt->execute([
            'peopleId' => $peopleId,
            'movieId' => $movieId
        ]);
        $castPeople = $stmt->fetchObject(self::class);
        if ($castPeople === false) {
            throw new EntityNotFoundException();
        }
        return $castPeople->role;
    }
}
