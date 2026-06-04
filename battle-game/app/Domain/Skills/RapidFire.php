<?php

// Activam tiparea stricta pentru skill.
declare(strict_types=1);

namespace App\Domain\Skills;

// RapidFire este skill-ul ofensiv al lui Kratos.
class RapidFire implements SkillInterface
{
    // Numele afisat in log atunci cand skill-ul este folosit.
    private const NAME = 'Rapid fire';

    // Sansa de activare este 15%.
    private const CHANCE = 15;

    // Returneaza numele skill-ului.
    public function getName(): string
    {
        // Trimitem numele definit in constanta.
        return self::NAME;
    }

    // Returneaza sansa procentuala de activare.
    public function getChance(): int
    {
        // Trimitem valoarea 15.
        return self::CHANCE;
    }

    // Returneaza tipul skill-ului.
    public function getType(): string
    {
        // Rapid Fire se aplica la atac.
        return self::TYPE_ATTACK;
    }

    // Verifica daca skill-ul se activeaza in tura curenta.
    public function activates(): bool
    {
        // Generam un numar intre 1 si 100 si il comparam cu sansa.
        return random_int(1, 100) <= self::CHANCE;
    }
}
