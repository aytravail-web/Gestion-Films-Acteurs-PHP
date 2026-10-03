<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;

class Genre
{
    private string $name;
    private ?int $id = null;

    /**
     * Récupère l'identifiant unique du genre
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Récupère le nom du genre
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Récupère tous les genres triés par nom dans l'ordre alphabétique
     * @return array
     */
    public static function findAll(): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            'SELECT id, name
            FROM genre
            ORDER BY name ASC'
        );
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }
}