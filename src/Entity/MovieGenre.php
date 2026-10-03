<?php

declare(strict_types=1);

namespace Entity;

class MovieGenre
{
    private int $movieId;
    private int $genreId;

    /**
     *  Récupère l'identifiant unique du film
     * @return int
     */
    public function getMovieId(): int
    {
        return $this->movieId;
    }

    /**
     *  Récupère l'identifiant unique du genre
     * @return int
     */
    public function getGenreId(): int
    {
        return $this->genreId;
    }

}
