<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Collection\MovieCollection;
use Entity\Exception\EntityNotFoundException;
use PDO;

class People
{
    private ?int $avatarId = null;
    private ?int $id = null;
    private ?string $birthday = null;
    private ?string $deathday = null;
    private string $name;
    private ?string $biography = null;
    private ?string $placeOfBirth = null;
    private ?string $role = null;


    /**
     * Récupère le rôle de la personne.
     *
     * @return string|null Le rôle de la personne ou null s'il n'est pas défini.
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * Récupère le nom de la personne.
     *
     * @return string Le nom de la personne.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Récupère l'identifiant unique de la personne.
     *
     * @return int|null L'identifiant unique ou null s'il n'est pas défini.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Récupère l'identifiant de l'avatar de la personne.
     *
     * @return int|null L'identifiant de l'avatar ou null s'il n'est pas défini.
     */
    public function getAvatarId(): ?int
    {
        return $this->avatarId;
    }

    /**
     * Récupère le lieu de naissance de la personne.
     *
     * @return string|null Le lieu de naissance ou null s'il n'est pas défini.
     */
    public function getPlaceOfBirth(): ?string
    {
        return $this->placeOfBirth;
    }

    /**
     * Récupère la biographie de la personne.
     *
     * @return string|null La biographie ou null si elle n'est pas définie.
     */
    public function getBiography(): ?string
    {
        return $this->biography;
    }

    /**
     * Récupère la date de décès de la personne.
     *
     * @return string|null La date de décès ou null si elle n'est pas définie.
     */
    public function getDeathday(): ?string
    {
        return $this->deathday;
    }

    /**
     * Récupère la date de naissance de la personne.
     *
     * @return string|null La date de naissance ou null si elle n'est pas définie.
     */
    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    /**
     * Récupère une personne à partir de son identifiant unique
     * @param int $id L'identifiant unique de la personne
     * @return People L'objet People correspondant à l'identifiant donné
     */
    public static function findById(int $id): People
    {
        $stmt = MyPdo::getInstance()->prepare(
            'SELECT avatarId, id, birthday, deathday, name, biography, placeOfBirth
        FROM people
        WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);
        $people = $stmt->fetchObject(self::class);
        if ($people === false) {
            throw new EntityNotFoundException();
        }
        return $people;
    }
    /**
     * Retourne tous les films de l'acteur
     * @return Movie[]
     */
    public function findMoviesByPeople(): array
    {
        return MovieCollection::findByPeopleId($this->id);
    }
}
