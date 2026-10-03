<?php

declare(strict_types=1);

use Entity\Cast;
use Entity\People;
use Entity\Exception\EntityNotFoundException;
use Html\AppWebPage;

if (!isset($_GET['peopleId']) || !ctype_digit($_GET['peopleId'])) {
    header('Location: index.php', true, 302);
    exit();
}

$peopleId = (int) $_GET['peopleId'];

try {
    $people = People::findById($peopleId);
} catch (EntityNotFoundException $e) {
    http_response_code(404);
    exit();
}

$webPage = new AppWebPage();
$peopleName = $webPage->escapeString($people->getName());
$webPage->setTitle("Acteur - " . $peopleName);
$webPage->appendMenu(
    "<a href='./index.php' class='menu__home'>" .
    "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 50 50'>" .
    "<path d='M 24.962891 1.0546875 A 1.0001 1.0001 0 0 0 24.384766 1.2636719 L 1.3847656 19.210938 A 1.0005659 1.0005659 0 0 0 2.6152344 20.789062 L 4 19.708984 L 4 46 A 1.0001 1.0001 0 0 0 5 47 L 18.832031 47 A 1.0001 1.0001 0 0 0 19.158203 47 L 30.832031 47 A 1.0001 1.0001 0 0 0 31.158203 47 L 45 47 A 1.0001 1.0001 0 0 0 46 46 L 46 19.708984 L 47.384766 20.789062 A 1.0005657 1.0005657 0 1 0 48.615234 19.210938 L 41 13.269531 L 41 6 L 35 6 L 35 8.5859375 L 25.615234 1.2636719 A 1.0001 1.0001 0 0 0 24.962891 1.0546875 z M 25 3.3222656 L 44 18.148438 L 44 45 L 32 45 L 32 26 L 18 26 L 18 45 L 6 45 L 6 18.148438 L 25 3.3222656 z M 37 8 L 39 8 L 39 11.708984 L 37 10.146484 L 37 8 z M 20 28 L 30 28 L 30 45 L 20 45 L 20 28 z'></path>" .
    "</svg>" .
    "</a>\n"
);

$webPage->appendContent("<div class='people__info__block'>\n");
$webPage->appendContent(
    "    <div class='people__info__image'>\n" .
    "        <img src='avatar.php?avatarId=" . $people->getAvatarId() . "' alt='Photo $peopleName'>\n" .
    "    </div>\n"
);
$webPage->appendContent("<div class='people__info__details'>\n");
$webPage->appendContent("    <div class='people__name__title'>$peopleName</div>\n");
$webPage->appendContent("    <div class='people__place'>" . $webPage->escapeString($people->getPlaceOfBirth() ?? '') . "</div>\n");

$birthday = $people->getBirthday();
$deathday = $people->getDeathday();
$datesHtml = "";
if ($birthday !== null) {
    $datesHtml .= $birthday;
}
if ($deathday !== null) {
    $datesHtml .= " - " . $deathday;
}
if ($datesHtml !== "") {
    $webPage->appendContent("    <div class='people__dates'>$datesHtml</div>\n");
}

$webPage->appendContent("    <div class='people__biography'>" . $webPage->escapeString($people->getBiography() ?? '') . "</div>\n");
$webPage->appendContent("</div>\n");
$webPage->appendContent("</div>\n");


$movies = $people->findMoviesByPeople();

foreach ($movies as $movie) {
    $title = $webPage->escapeString($movie->getTitle());
    $posterId = $movie->getPosterId();
    $movieId = $movie->getId();
    $role = $webPage->escapeString(Cast::findRoleByPeopleAndMovie($peopleId, $movieId) ?? '');

    $webPage->appendContent(
        "<a href='./movie.php?movieId=$movieId' class='movie__card'>\n" .
        "    <div class='movie__card__poster'>\n" .
        "        <img src='image.php?posterId=$posterId' alt='Poster $title'>\n" .
        "    </div>\n" .
        "    <div class='movie__card__info'>\n" .
        "        <div class='movie__card__top'>\n" .
        "            <div class='movie__card__title'>$title</div>\n" .
        "            <div class='movie__card__date'>" . $movie->getReleaseDate() . "</div>\n" .
        "        </div>\n" .
        "        <div class='movie__card__role'>$role</div>\n" .
        "    </div>\n" .
        "</a>\n"
    );
}

echo $webPage->toHTML();
