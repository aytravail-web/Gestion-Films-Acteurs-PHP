<?php

declare(strict_types=1);

use Entity\Exception\ParameterException;
use Html\Form\MovieForm;

try {
    $movieForm = new MovieForm();
    $movieForm->setEntityFromQueryString();
    $movie = $movieForm->getMovie();
    $movie->save();

    header('Location: /movie.php?movieId=' . $movie->getId());
    exit;

} catch (ParameterException) {
    http_response_code(400);
} catch (\Throwable) {
    http_response_code(500);
}
