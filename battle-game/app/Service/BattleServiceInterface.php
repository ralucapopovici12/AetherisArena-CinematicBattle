<?php

// Activam tiparea stricta pentru contractul service-ului.
declare(strict_types=1);

namespace App\Service;

use App\Domain\Entities\Battle;
use App\Domain\Entities\Character;

// Interfata defineste ce trebuie sa ofere orice serviciu de lupta.
interface BattleServiceInterface
{
    // Simuleaza o lupta completa intre doua personaje.
    public function simulate(Character $hero, Character $monster): Battle;

    // Returneaza istoricul luptelor simulate in instanta curenta.
    public function getBattleHistory(): array;

    // Cauta o lupta dupa id in istoricul curent.
    public function getBattleById(int $id): ?Battle;
}
