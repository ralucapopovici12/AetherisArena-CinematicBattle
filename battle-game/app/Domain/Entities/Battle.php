<?php

// Activam tiparea stricta pentru obiectul Battle.
declare(strict_types=1);

// Battle este o entitate din domain.
namespace App\Domain\Entities;

// Battle reprezinta rezultatul complet al unei lupte.
class Battle extends Entity
{
    // Personajul principal al luptei.
    private Character $hero;

    // Monstrul impotriva caruia lupta eroul.
    private Character $monster;

    // Numele castigatorului sau null daca este egalitate.
    private ?string $winner;

    // Numarul de ture executate in lupta.
    private int $turns;

    // Lista de log-uri generate pentru fiecare tura.
    private array $logs;

    // Constructorul primeste toate datele importante ale luptei.
    public function __construct(Character $hero, Character $monster, ?string $winner, int $turns, array $logs)
    {
        // Salvam eroul pe obiectul Battle.
        $this->hero = $hero;

        // Salvam monstrul pe obiectul Battle.
        $this->monster = $monster;

        // Salvam castigatorul calculat de service.
        $this->winner = $winner;

        // Salvam numarul de ture executate.
        $this->turns = $turns;

        // Salvam log-urile generate pe ture.
        $this->logs = $logs;
    }

    // Returneaza eroul implicat in lupta.
    public function getHero(): Character
    {
        // Trimitem obiectul erou.
        return $this->hero;
    }

    // Returneaza monstrul implicat in lupta.
    public function getMonster(): Character
    {
        // Trimitem obiectul monstru.
        return $this->monster;
    }

    // Returneaza castigatorul luptei.
    public function getWinner(): ?string
    {
        // Trimitem numele castigatorului sau null.
        return $this->winner;
    }

    // Returneaza numarul de ture executate.
    public function getTurns(): int
    {
        // Trimitem numarul de ture.
        return $this->turns;
    }

    // Returneaza log-urile luptei.
    public function getLogs(): array
    {
        // Trimitem lista de log-uri.
        return $this->logs;
    }

    // Transforma obiectul intr-un array usor de afisat in API sau frontend.
    public function toArray(): array
    {
        // Construim structura finala pentru output.
        return [
            // Afisam id-ul luptei.
            'id' => $this->getId(),

            // Afisam numele eroului.
            'hero' => $this->hero->getName(),

            // Afisam numele monstrului.
            'monster' => $this->monster->getName(),

            // Afisam castigatorul sau null.
            'winner' => $this->winner,

            // Afisam numarul de ture.
            'turns' => $this->turns,

            // Afisam log-urile generate.
            'logs' => $this->logs,
        ];
    }
}
