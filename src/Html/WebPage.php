<?php

declare(strict_types=1);

namespace Html;

class WebPage
{
    use StringEscaper;
    private string $head = "";
    private string $title = "";
    private string $body = "";

    /**
     * Initialise la page avec un titre optionnel.
     * @param string $title Le titre de la page (vide par défaut).
     */
    public function __construct(string $title = "")
    {
        $this->title = $title;
    }

    /**
     * Récupère le contenu de la balise head.
     * @return string Le contenu HTML de la balise head.
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * Récupère le titre de la page.
     * @return string Le titre de la page.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Définit le titre de la page.
     * @param string $title Le nouveau titre de la page.
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Récupère le contenu du corps de la page.
     * @return string Le contenu HTML du corps de la page.
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Ajoute du contenu à la balise head.
     * @param string $content Le contenu HTML à ajouter à la balise head.
     * @return void
     */
    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }

    /**
     * Ajoute un style CSS inline à la balise head
     * @param string $css Le code CSS à ajouter.
     * @return void
     */
    public function appendCss(string $css): void
    {
        $this->appendToHead("<style>\n$css\n</style>");
    }

    /**
     * Ajoute une feuille de style CSS externe à la balise head.
     * @param string $url L'URL de la feuille de style CSS.
     * @return void
     */
    public function appendCssUrl(string $url): void
    {
        $this->appendToHead('<link rel="stylesheet" href="'.$url.'">');
    }

    /**
     * Ajoute un script JavaScript inline à la balise head.
     * @param string $js Le code JavaScript à ajouter.
     * @return void
     */
    public function appendJs(string $js): void
    {
        $this->appendToHead("<script>\n$js\n</script>");
    }

    /**
     * Ajoute un script JavaScript externe à la balise head.
     * @param string $url L'URL du fichier JavaScript.
     * @return void
     */
    public function appendJsUrl(string $url): void
    {
        $this->appendToHead('<script src="'.$url.'"></script>');
    }

    /**
     * Ajoute du contenu au corps de la page.
     * @param string $content Le contenu HTML à ajouter au corps de la page.
     * @return void
     */
    public function appendContent(string $content): void
    {
        $this->body .= $content;
    }

    /**
     * Génère le code HTML complet de la page.
     * @return string Le code HTML complet de la page.
     */
    public function toHTML(): string
    {
        return "<!DOCTYPE html>\n"
            . "<html lang=\"fr\">\n"
            . "<head>\n"
            . "  <meta charset=\"UTF-8\">\n"
            . "  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n"
            . "  <title>{$this->title}</title>\n"
            . $this->head . "\n"
            . "</head>\n"
            . "<body>\n"
            . $this->body . "\n"
            .self::getLastModification()
            . "</body>\n"
            . "</html>";
    }

    /**
     * Récupère la date et l'heure de la dernière modification du fichier courant.
     * @return string La date de dernière modification au format dd/mm/YYYY HH:mm:ss.
     */
    public static function getLastModification(): string
    {
        return date("d/m/Y H:i:s", getlastmod());
    }



}
