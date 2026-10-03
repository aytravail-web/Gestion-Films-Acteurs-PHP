<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Movie;
use Html\AppWebPage;

if (!isset($_GET['movieId']) || !ctype_digit($_GET['movieId'])) {
    header('Location: index.php', true, 302);
    exit();
}

$movieId = (int) $_GET['movieId'];

try {
    $movie = Movie::findById($movieId);
} catch (EntityNotFoundException $e) {
    http_response_code(404);
    exit();
}

$webPage = new AppWebPage();
$movieTitle = $webPage->escapeString($movie->getTitle());
$webPage->setTitle("Films - " . $movieTitle);

$webPage->appendMenu(
    "<a href='./index.php' class='menu__home'>" .
    "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 50 50'>" .
    "<path d='M 24.962891 1.0546875 A 1.0001 1.0001 0 0 0 24.384766 1.2636719 L 1.3847656 19.210938 A 1.0005659 1.0005659 0 0 0 2.6152344 20.789062 L 4 19.708984 L 4 46 A 1.0001 1.0001 0 0 0 5 47 L 18.832031 47 A 1.0001 1.0001 0 0 0 19.158203 47 L 30.832031 47 A 1.0001 1.0001 0 0 0 31.158203 47 L 45 47 A 1.0001 1.0001 0 0 0 46 46 L 46 19.708984 L 47.384766 20.789062 A 1.0005657 1.0005657 0 1 0 48.615234 19.210938 L 41 13.269531 L 41 6 L 35 6 L 35 8.5859375 L 25.615234 1.2636719 A 1.0001 1.0001 0 0 0 24.962891 1.0546875 z M 25 3.3222656 L 44 18.148438 L 44 45 L 32 45 L 32 26 L 18 26 L 18 45 L 6 45 L 6 18.148438 L 25 3.3222656 z M 37 8 L 39 8 L 39 11.708984 L 37 10.146484 L 37 8 z M 20 28 L 30 28 L 30 45 L 20 45 L 20 28 z'></path>" .
    "</svg>" .
    "</a>\n" .
    "<div class='menu__actions'>\n" .
    "    <a href='./admin/movie-form.php?movieId=$movieId' class='menu__edit'>Modifier</a>\n" .
    "    <form method='post' action='./admin/movie-delete.php?movieId=$movieId' class='menu__delete__form'>\n" .
    "        <input type='hidden' name='id' value='$movieId'>\n" .
    "        <button type='submit'>Supprimer</button>\n" .
    "    </form>\n" .
    "</div>\n"
);

$webPage->appendContent("<div class='content'>\n");

$webPage->appendContent("<div class='movie__info'>\n");
$webPage->appendContent(
    "    <div class='movie__info__image'>\n" .
    "        <img src='image.php?posterId=" . $movie->getPosterId() . "' alt='Poster $movieTitle'>\n" .
    "    </div>\n"
);
$webPage->appendContent("<div class='movie__info__details'>\n");
$webPage->appendContent(
    "    <div class='movie__top__line'>\n" .
    "        <div class='movie__info__title'><p>" . $movieTitle . "</p></div>\n" .
    "        <div class='movie__date'><p>" . $movie->getReleaseDate() . "</p></div>\n" .
    "    </div>\n"
);
$webPage->appendContent("    <div class='movie__original__title'><p>" . $webPage->escapeString($movie->getOriginalTitle()) . "</p></div>\n");
$webPage->appendContent("    <div class='movie__slogan'><p>" . $webPage->escapeString($movie->getTagline()) . "</p></div>\n");
$webPage->appendContent("    <div class='movie__summary'><p>" . $webPage->escapeString($movie->getOverview()) . "</p></div>\n");
$webPage->appendContent("</div>\n");
$webPage->appendContent("</div>\n");

$peoples = $movie->findAllPeopleFromMovie();

foreach ($peoples as $people) {
    $role = $webPage->escapeString($people->getRole());
    $name = $webPage->escapeString($people->getName());
    $avatarId = $people->getAvatarId();
    $peopleId = $people->getId();

    $webPage->appendContent(
        "<a href='./people.php?peopleId=$peopleId' class='people'>\n" .
        "    <div class='people__avatar'>\n" .
        "        <img src='avatar.php?avatarId=$avatarId' alt='Photo $name'>\n" .
        "    </div>\n" .
        "    <div class='people__info'>\n" .
        "        <div class='people__role'><p>$role</p></div>\n" .
        "        <div class='people__name'><p>$name</p></div>\n" .
        "    </div>\n" .
        "</a>\n"
    );
}

$webPage->appendContent("</div>\n");

echo $webPage->toHTML();
