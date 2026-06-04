<?php

// Activam tiparea stricta pentru constructor si valori.
declare(strict_types=1);

namespace App\Domain\Entities;

class Kratos extends Character
{
    // Constructorul primeste toate datele deja pregatite de factory.
    public function __construct(
        string $name,
        int $health,
        int $strength,
        int $defence,
        int $speed,
        float $luck,
        ?int $id = null
    ) {
        // Initializam partea comuna din Character.
        parent::__construct($name, $health, $strength, $defence, $speed, $luck, $id);
    }
}
