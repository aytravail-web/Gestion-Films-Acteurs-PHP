<?php

declare(strict_types=1);

namespace Html;

class AppWebPage extends WebPage
{
    use StringEscaper;

    private string $menu = '';

    /**
     * Initialise la page avec un titre et ajoute la feuille de style principale
     * @param string $title
     */
    public function __construct(string $title = '')
    {
        parent::__construct($title);
        $this->appendCssUrl('/css/style.css');
    }

    /**
     * Ajoute du contenu au menu de la page
     * @param string $content
     * @return void
     */
    public function appendMenu(string $content): void
    {
        $this->menu .= $content;
    }

    /**
     * Génère le code HTML complet de la page.
     * Inclut l'en-tête, le menu de navigation, le contenu principal et le pied de page
     * avec la date de dernière modification
     * @return string
     */
    public function toHTML(): string
    {
        return "<!DOCTYPE html>\n"
            . "<html lang=\"fr\">\n"
            . "<head>\n"
            . "    <meta charset=\"UTF-8\">\n"
            . "    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n"
            . "    <title>{$this->getTitle()}</title>\n"
            . $this->getHead() . "\n"
            . "</head>\n"
            . "<body>\n"
            . "    <header class=\"header\">\n"
            . "        <h1>" . $this->escapeString($this->getTitle()) . "</h1>\n"
            . "    </header>\n"
            . "    <nav class=\"menu\">\n"
            .          $this->menu . "\n"
            . "    </nav>\n"
            . "    <main class=\"content\">\n"
            .          $this->getBody() . "\n"
            . "    </main>\n"
            . "    <footer class=\"footer\">\n"
            . "        Dernière modification : " . self::getLastModification() . "\n"
            . "    </footer>\n"
            . "</body>\n"
            . "</html>";
    }
}
