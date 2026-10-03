<?php

declare(strict_types=1);

namespace Html;

trait StringEscaper
{
    /**
     * Échappe les caractères spéciaux HTML d'une chaîne de caractères
     * @param string|null $text La chaîne à échapper, ou null
     * @return string
     */
    public function escapeString(?string $text): string
    {
        if ($text === null) {
            return '';
        }
        return htmlspecialchars($text, ENT_QUOTES | ENT_HTML5);
    }

    /**
     * Supprime les balises HTML et les espaces en début et fin d'une chaîne de caractères
     * @param string|null $text La chaîne à traiter, ou null
     * @return string
     */
    public function stripTagsAndTrim(?string $text): string
    {
        if ($text === null) {
            return '';
        }
        return trim(strip_tags($text));
    }
}
