<?php

// Activam tiparea stricta pentru a evita conversii ascunse.
declare(strict_types=1);

namespace App\Domain\Entities;
use App\Domain\Skills\SkillInterface;

abstract class Character extends Entity
{
    // Numele personajului afisat in log-uri.
    protected string $name;

    protected int $health;

    protected int $strength;

    protected int $defence;

    protected int $speed;

    protected float $luck;

    protected array $skills = [];

    public function __construct(
        string $name,
        int $health,
        int $strength,
        int $defence,
        int $speed,
        float $luck,
        ?int $id = null
    ) {
        // Salvam id-ul daca obiectul vine din baza de date.
        $this->id = $id;

        // Salvam numele pe obiect.
        $this->name = $name;

        $this->health = $health;

        $this->strength = $strength;

        $this->defence = $defence;

        $this->speed = $speed;

        $this->luck = $luck;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHealth(): int
    {
        return $this->health;
    }

    public function getStrength(): int
    {
        return $this->strength;
    }

    public function getDefence(): int
    {
        return $this->defence;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function getLuck(): float
    {
        return $this->luck;
    }

    // Scade damage-ul primit din viata personajului.
    public function takeDamage(int $damage): void
    {
        // Daca damage-ul este zero sau negativ, nu modificam viata.
        if ($damage <= 0) {
            // Iesim din functie fara alte efecte.
            return;
        }

        // Scadem damage-ul primit din health.
        $this->health -= $damage;

        // Daca viata a scazut sub zero, o limitam la zero.
        if ($this->health < 0) {
            // Setam health la zero pentru un output curat.
            $this->health = 0;
        }
    }

    // Verifica daca personajul inca este in viata.
    public function isAlive(): bool
    {
        // Un personaj traieste daca are health mai mare decat zero.
        return $this->health > 0;
    }

    // Adauga un skill nou personajului.
    public function addSkill(SkillInterface $skill): void
    {
        // Punem skill-ul in lista interna.
        $this->skills[] = $skill;
    }

    public function getSkills(): array
    {
        return $this->skills;
    }
}
