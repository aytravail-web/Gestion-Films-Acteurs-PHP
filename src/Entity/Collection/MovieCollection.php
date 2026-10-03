<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Movie;
use PDO;

class MovieCollection
{
    /**
     * Retourne tous les film sans ordre donnés
     *
     * @return movie[]
     */
    public static function findAll(): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            SELECT posterId, originalLanguage, originalTitle, overview,releaseDate, runtime,tagline,title,id
            FROM movie
            SQL
        );

        $stmt->execute();

        return $stmt->fetchAll(
            PDO::FETCH_CLASS,
            Movie::class
        );
    }

    /**
     *  Récupère tous les films associés à une personne spécifique
     * @param int $peopleId L'identifiant unique de la personne.
     * @return array
     */
    public static function findByPeopleId(int $peopleId): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            'SELECT m.posterId, m.originalLanguage, m.originalTitle, m.overview,
                m.releaseDate, m.runtime, m.tagline, m.title, m.id
        FROM movie m
        JOIN cast c ON m.id = c.movieId
        WHERE c.peopleId = :peopleId'
        );
        $stmt->execute(['peopleId' => $peopleId]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Movie::class);
    }

    /**
     *  Récupère tous les films associés à un genre spécifique.
     * @param int $genreId L'identifiant unique du genre
     * @return array
     */
    public static function findByGenreId(int $genreId): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            'SELECT m.posterId,
                m.originalLanguage,
                m.originalTitle,
                m.overview,
                m.releaseDate,
                m.runtime,
                m.tagline,
                m.title,
                m.id
        FROM movie m
        INNER JOIN movie_genre mg
            ON m.id = mg.movieId
        WHERE mg.genreId = :genreId'
        );

        $stmt->execute([
            'genreId' => $genreId
        ]);

        return $stmt->fetchAll(
            \PDO::FETCH_CLASS,
            Movie::class
        );
    }
}