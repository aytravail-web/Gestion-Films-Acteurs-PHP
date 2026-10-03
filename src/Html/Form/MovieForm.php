<?php

declare(strict_types=1);

namespace Html\Form;

use Entity\Movie;
use Entity\Exception\ParameterException;
use Html\StringEscaper;

class MovieForm
{
    use StringEscaper;
    private ?Movie $movie;

    /**
     * Initialise le formulaire avec un film optionnel
     * @param Movie|null $movie
     */
    public function __construct(?Movie $movie = null)
    {
        $this->movie = $movie;
    }

    /**
     * Récupère le film associé au formulaire
     * @return Movie|null
     */
    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    /**
     * Génère le formulaire HTML pour la création ou la modification d'un film
     * Les champs sont remplis avec les données du film si il existe
     * @param string $action
     * @return string
     */
    public function getHtmlForm(string $action): string
    {
        $id = $this->movie?->getId();
        $title = $this->escapeString($this->movie?->getTitle() ?? '');
        $originalTitle = $this->escapeString($this->movie?->getOriginalTitle() ?? '');
        $originalLanguage = $this->escapeString($this->movie?->getOriginalLanguage() ?? '');
        $overview = $this->escapeString($this->movie?->getOverview() ?? '');
        $releaseDate = $this->escapeString($this->movie?->getReleaseDate() ?? '');
        $runtime = $this->movie?->getRuntime();
        $tagline = $this->escapeString($this->movie?->getTagline() ?? '');

        return '
    <form method="post" action="' . $this->escapeString($action) . '" class="movie__form">
        <input type="hidden" name="id" value="' . $id . '">

        <div>
            <label for="title">Titre</label>
            <input type="text" id="title" name="title" required value="' . $title . '">
        </div>

        <div>
            <label for="originalTitle">Titre original</label>
            <input type="text" id="originalTitle" name="originalTitle" required value="' . $originalTitle . '">
        </div>

        <div>
            <label for="originalLanguage">Langue originale</label>
            <input type="text"
                   id="originalLanguage"
                   name="originalLanguage"
                   required
                   maxlength="2"
                   pattern="[a-z]{2}"
                   placeholder="ex: en, fr"
                   value="' . $originalLanguage . '">        
       </div>

        <div>
            <label for="releaseDate">Date de sortie</label>
            <input type="date" id="releaseDate" name="releaseDate" required value="' . $releaseDate . '">
        </div>

        <div>
            <label for="runtime">Durée (minutes)</label>
            <input type="number" id="runtime" name="runtime" min="1" required value="' . ($runtime ?? '') . '">
        </div>

        <div>
            <label for="tagline">Slogan</label>
            <input type="text" id="tagline" name="tagline" value="' . $tagline . '">
        </div>

        <div>
            <label for="overview">Résumé</label>
            <textarea id="overview" name="overview" required>' . $overview . '</textarea>
        </div>

        <button type="submit">Enregistrer</button>
    </form>';
    }

    /**
     * Initialise l'entité film à partir des données du formulaire POST
     *  Valide et assainit chaque champ avant de créer l'objet Movie
     * @return void
     * @throws ParameterException Si un champ obligatoire est manquant ou invalide :
     *                             - Le titre est manquant.
     *                             - Le titre original est manquant.
     *                             - La langue originale n'est pas un code à 2 lettres.
     *                             - Le résumé est manquant.
     *                             - La date de sortie est manquante.
     *                             - La durée est invalide.
     */
    public function setEntityFromQueryString(): void
    {
        $id = null;
        if (isset($_POST['id']) && ctype_digit($_POST['id'])) {
            $id = (int) $_POST['id'];
        }

        $title = $this->stripTagsAndTrim($_POST['title'] ?? null);
        if ($title === '') {
            throw new ParameterException('Le titre du film est manquant');
        }

        $originalTitle = $this->stripTagsAndTrim($_POST['originalTitle'] ?? null);
        if ($originalTitle === '') {
            throw new ParameterException('Le titre original est manquant');
        }

        $originalLanguage = $this->stripTagsAndTrim($_POST['originalLanguage'] ?? null);
        if (!preg_match('/^[a-z]{2}$/', $originalLanguage)) {
            throw new ParameterException('La langue originale doit être un code à 2 lettres (ex: en, fr)');
        }

        $overview = $this->stripTagsAndTrim($_POST['overview'] ?? null);
        if ($overview === '') {
            throw new ParameterException('Le résumé est manquant');
        }

        $releaseDate = $this->stripTagsAndTrim($_POST['releaseDate'] ?? null);
        if ($releaseDate === '') {
            throw new ParameterException('La date de sortie est manquante');
        }

        if (!isset($_POST['runtime']) || !ctype_digit((string) $_POST['runtime'])) {
            throw new ParameterException('La durée est invalide');
        }
        $runtime = (int) $_POST['runtime'];

        $tagline = $this->stripTagsAndTrim($_POST['tagline'] ?? null);
        $tagline = $tagline === '' ? null : $tagline;

        $this->movie = Movie::create(
            $title,
            $originalTitle,
            $originalLanguage,
            $overview,
            $releaseDate,
            $runtime,
            $tagline,
            $id
        );
    }
}
