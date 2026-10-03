<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Collection\PeopleCollection;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Movie
{
    private ?int $posterId = null;
    private ?int $id = null;
    private string $originalLanguage;
    private string $originalTitle;
    private string $overview;
    private string $releaseDate;
    private int $runtime;
    private string $title;
    private ?string $tagline = null;

    public static function create(
        string $title,
        string $originalTitle,
        string $originalLanguage,
        string $overview,
        string $releaseDate,
        int $runtime,
        ?string $tagline,
        ?int $id
    ): self {
        $movie = new self();
        $movie->id = $id;
        $movie->title = $title;
        $movie->originalTitle = $originalTitle;
        $movie->originalLanguage = $originalLanguage;
        $movie->overview = $overview;
        $movie->releaseDate = $releaseDate;
        $movie->runtime = $runtime;
        $movie->tagline = $tagline;
        return $movie;
    }

    /**
     * Retourne l'ID si présent si non retourne null
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /** retourne le titre original
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    /**retorune la version original du language
     * @return string
     */
    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }

    /** Retourne l'overview
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /** Retourne la date de sortie du film
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /** Retourne l'Id de poster si présent sinon null
     * @return int
     */
    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    /** Retourne la duréé du film
     * @return int
     */
    public function getRuntime(): int
    {
        return $this->runtime;
    }

    /** Retourne le Slogan du film si présent si non null
     * @return string
     */
    public function getTagline(): ?string
    {
        return $this->tagline;
    }

    /** Retourne le titre du film
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Récupère un film à partir de son identifiant unique
     * @param int $id L'identifiant unique du film
     * @return Movie
     */
    public static function findById(int $id): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            'SELECT posterId, originalLanguage, originalTitle, overview,releaseDate, runtime,tagline,title,id
            FROM movie
            WHERE id = :id'
        );
        $stmt->execute([
            'id' => $id
        ]);
        $movie = $stmt->fetchObject(self::class);
        if ($movie === false) {
            throw new EntityNotFoundException();
        }
        return $movie;
    }

    /**
     * Récupère toutes les personnes associées à ce film
     * @return People[]
     */
    public function findAllPeopleFromMovie(): array
    {
        return PeopleCollection::findByMovieId($this->id);
    }

    /**
     *  Sauvegarde le film en base de données.
     *  Si l'identifiant est null, insère un nouveau film et assigne l'identifiant généré
     *  Sinon ça met à jour le film existant correspondant à l'identifiant
     * @return void
     */
    public function save(): void
    {
        if ($this->id === null) {
            $stmt = MyPdo::getInstance()->prepare(
                'INSERT INTO movie (title, originalTitle, originalLanguage, overview, releaseDate, runtime, tagline)
                VALUES (:title, :originalTitle, :originalLanguage, :overview, :releaseDate, :runtime, :tagline)'
            );
            $stmt->execute([
                'title' => $this->title,
                'originalTitle' => $this->originalTitle,
                'originalLanguage' => $this->originalLanguage,
                'overview' => $this->overview,
                'releaseDate' => $this->releaseDate,
                'runtime' => $this->runtime,
                'tagline' => $this->tagline,
            ]);
            $this->id = (int) MyPdo::getInstance()->lastInsertId();
        } else {
            $stmt = MyPdo::getInstance()->prepare(
                'UPDATE movie
                SET title = :title,
                    originalTitle = :originalTitle,
                    originalLanguage = :originalLanguage,
                    overview = :overview,
                    releaseDate = :releaseDate,
                    runtime = :runtime,
                    tagline = :tagline
                WHERE id = :id'
            );
            $stmt->execute([
                'title' => $this->title,
                'originalTitle' => $this->originalTitle,
                'originalLanguage' => $this->originalLanguage,
                'overview' => $this->overview,
                'releaseDate' => $this->releaseDate,
                'runtime' => $this->runtime,
                'tagline' => $this->tagline,
                'id' => $this->id,
            ]);
        }
    }

    /**
     * Supprime le film de la base de données.
     * Si l'identifiant est null, aucune action n'est effectuée.
     * @return void
     */
    public function delete(): void
    {
        if ($this->id === null) {
            return;
        }
        $stmt = MyPdo::getInstance()->prepare('DELETE FROM movie WHERE id = :id');
        $stmt->execute(['id' => $this->id]);
    }






}
