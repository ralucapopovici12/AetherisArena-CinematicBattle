<?php

// Activam tiparea stricta pentru valori mai previzibile.
declare(strict_types=1);

namespace App\Domain\Entities;
abstract class Entity
{
    // Id-ul este optional pentru ca obiectul poate exista inainte sa fie salvat
    protected ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
