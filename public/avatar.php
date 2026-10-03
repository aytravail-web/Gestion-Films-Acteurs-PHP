<?php

declare(strict_types=1);

use Entity\Image;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;

try {
    if (!isset($_GET['avatarId']) || !ctype_digit($_GET['avatarId'])) {
        throw new ParameterException();
    }
    $avatarId = (int) $_GET['avatarId'];
    $image = Image::findById($avatarId);
    header('Content-Type: image/jpeg');
    echo $image->getJpeg();
} catch (ParameterException $e) {
    http_response_code(302);
    header('Location: /img/actor.png');
} catch (EntityNotFoundException $e) {
    http_response_code(302);
    header('Location: /img/actor.png');
}
