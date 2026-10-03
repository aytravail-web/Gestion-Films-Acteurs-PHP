<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Image
{
    private string $jpeg;
    private ?int $id = null;

    /**
     * Recupère l'identifiant unique de l'image
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Recupère l'image
     * @return string
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /**
     * Récupère une image à partir de son identifiant unique
     * @param int $id L'identifiant unique de l'image
     * @return Image L'objet Image correspondant à l'identifiant donné
     */
    public static function findById(int $id): Image
    {
        $stmt = MyPdo::getInstance()->prepare(
            'SELECT id, jpeg
            FROM image
            WHERE id = :id'
        );

        $stmt->execute([
            'id' => $id
        ]);

        $image = $stmt->fetchObject(self::class);

        if ($image === false) {
            throw new EntityNotFoundException();
        }

        return $image;

    }

}
