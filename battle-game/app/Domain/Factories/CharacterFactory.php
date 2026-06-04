<?php

// Activam tiparea stricta pentru factory.
declare(strict_types=1);

namespace App\Domain\Factories;

use App\Domain\Entities\Character;
use App\Domain\Entities\Kratos;
use App\Domain\Entities\Monster;
use App\Domain\Skills\MagicArmour;
use App\Domain\Skills\RapidFire;

use InvalidArgumentException;

// Factory-ul centralizeaza crearea personajelor si generarea stats-urilor.
class CharacterFactory
{
    // Constanta pentru tipul eroului.
    public const TYPE_KRATOS = 'kratos';

    // Constanta pentru tipul monstrului.
    public const TYPE_MONSTER = 'monster';

    // Creeaza o instanta noua de Kratos.
    public function createKratos(): Kratos
    {
        $health = random_int(65, 100);

        $strength = random_int(75, 90);

        $defence = random_int(40, 50);

        $speed = random_int(40, 50);

        $luck = random_int(10, 20) / 100;

        // Construim eroul cu stats-urile generate.
        $kratos = new Kratos(
            name: 'Kratos',
            health: $health,
            strength: $strength,
            defence: $defence,
            speed: $speed,
            luck: $luck
        );

        // Adaugam skill-ul ofensiv in factory.
        $kratos->addSkill(new RapidFire());

        // Adaugam skill-ul defensiv in factory.
        $kratos->addSkill(new MagicArmour());

        // Returnam eroul complet configurat.
        return $kratos;
    }

    // Creeaza o instanta noua de monstru salbatic.
    public function createMonster(): Monster
    {
        $health = random_int(50, 80);

        $strength = random_int(55, 80);

        $defence = random_int(50, 70);

        $speed = random_int(40, 60);

        $luck = random_int(30, 45) / 100;

        // Construim monstrul cu stats-urile generate.
        return new Monster(
            name: 'Wild Monster',
            health: $health,
            strength: $strength,
            defence: $defence,
            speed: $speed,
            luck: $luck
        );
    }


    // Creeaza un personaj dupa tipul primit ca text.
    public function create(string $type): Character
    {
        // Normalizam tipul si alegem clasa potrivita.
        return match (strtolower($type)) {
            // Pentru tipul kratos cream eroul.
            self::TYPE_KRATOS => $this->createKratos(),

            // Pentru tipul monster cream monstrul.
            self::TYPE_MONSTER => $this->createMonster(),

            // Pentru orice alt tip aruncam eroare clara.
            default => throw new InvalidArgumentException('Unknown character type: ' . $type),
        };
    }
}
