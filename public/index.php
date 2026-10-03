<?php

declare(strict_types=1);

use Entity\Collection\MovieCollection;
use Entity\Genre;
use Html\AppWebPage;

$webPage = new AppWebPage();

$webPage->setTitle("Films");

$webPage->appendMenu(
    "<a href='./index.php' class='menu__home'>" .
    "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 50 50'>" .
    "<path d='M 24.962891 1.0546875 A 1.0001 1.0001 0 0 0 24.384766 1.2636719 L 1.3847656 19.210938 A 1.0005659 1.0005659 0 0 0 2.6152344 20.789062 L 4 19.708984 L 4 46 A 1.0001 1.0001 0 0 0 5 47 L 18.832031 47 A 1.0001 1.0001 0 0 0 19.158203 47 L 30.832031 47 A 1.0001 1.0001 0 0 0 31.158203 47 L 45 47 A 1.0001 1.0001 0 0 0 46 46 L 46 19.708984 L 47.384766 20.789062 A 1.0005657 1.0005657 0 1 0 48.615234 19.210938 L 41 13.269531 L 41 6 L 35 6 L 35 8.5859375 L 25.615234 1.2636719 A 1.0001 1.0001 0 0 0 24.962891 1.0546875 z M 25 3.3222656 L 44 18.148438 L 44 45 L 32 45 L 32 26 L 18 26 L 18 45 L 6 45 L 6 18.148438 L 25 3.3222656 z M 37 8 L 39 8 L 39 11.708984 L 37 10.146484 L 37 8 z M 20 28 L 30 28 L 30 45 L 20 45 L 20 28 z'></path>" .
    "</svg>" .
    "</a>\n"
);

$webPage->appendMenu(
    "<a href='./admin/movie-form.php' class='menu__create'>+ Ajouter un film</a>\n"
);

$genreId = null;

if (
    isset($_GET['genreId'])
    && ctype_digit($_GET['genreId'])
) {
    $genreId = (int)$_GET['genreId'];
}

$genres = Genre::findAll();

if ($genreId === null) {
    $movies = MovieCollection::findAll();
} else {
    $movies = MovieCollection::findByGenreId($genreId);
}

$webPage->appendContent(
    "<form method='get' class='genre__filter'>\n" .
    "    <select name='genreId'>\n" .
    "        <option value=''>Tous les genres</option>\n"
);

foreach ($genres as $genre) {

    $selected = "";

    if ($genre->getId() === $genreId) {
        $selected = " selected";
    }

    $webPage->appendContent(
        "        <option value='" .
        $genre->getId() .
        "'" .
        $selected .
        ">" .
        $webPage->escapeString($genre->getName()) .
        "</option>\n"
    );
}

$webPage->appendContent(
    "    </select>\n" .
    "    <button type='submit'>Filtrer</button>\n" .
    "</form>\n"
);

$webPage->appendContent("<div class='content'>\n");

foreach ($movies as $movie) {

    $title = $webPage->escapeString($movie->getTitle());
    $id = $movie->getId();
    $posterId = $movie->getPosterId();

    $webPage->appendContent(
        "<a href='./movie.php?movieId=$id' class='movie'>\n" .
        "    <div class='movie__poster'>\n" .
        "        <img src='image.php?posterId=$posterId' alt='Poster $title'>\n" .
        "    </div>\n" .
        "    <div class='movie__title'><p>$title</p></div>\n" .
        "</a>\n"
    );
}

$webPage->appendContent("</div>\n");

echo $webPage->toHTML();