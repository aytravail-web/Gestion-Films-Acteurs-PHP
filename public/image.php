<?php

declare(strict_types=1);

use Entity\Image;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;

try {
    if (!isset($_GET['posterId']) || !ctype_digit($_GET['posterId'])) {
        throw new ParameterException();
    }
    $posterId = (int) $_GET['posterId'];
    $image = Image::findById($posterId);
    header('Content-Type: image/jpeg');
    echo $image->getJpeg();
} catch (ParameterException $e) {
    http_response_code(302);
    header('Location: /img/movie.png');
} catch (EntityNotFoundException $e) {
    http_response_code(302);
    header('Location: /img/movie.png');
}
