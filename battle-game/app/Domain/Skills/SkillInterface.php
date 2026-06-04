<?php

// Activam tiparea stricta pentru contractul skill-urilor.
declare(strict_types=1);

namespace App\Domain\Skills;

// Interfata defineste ce trebuie sa stie orice skill.
interface SkillInterface
{
    // Tip folosit pentru skill-uri care se aplica la atac.
    public const TYPE_ATTACK = 'attack';

    // Tip folosit pentru skill-uri care se aplica la aparare.
    public const TYPE_DEFENCE = 'defence';

    // Returneaza numele skill-ului.
    public function getName(): string;

    // Returneaza sansa procentuala de activare.
    public function getChance(): int;

    // Returneaza tipul skill-ului: attack sau defence.
    public function getType(): string;

    // Decide daca skill-ul se activeaza in momentul curent.
    public function activates(): bool;
}
