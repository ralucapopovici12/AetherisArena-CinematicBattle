<?php

// Activam tiparea stricta pentru service.
declare(strict_types=1);

namespace App\Service;

use App\Domain\Entities\Battle;
use App\Domain\Entities\Character;
use App\Domain\Skills\MagicArmour;
use App\Domain\Skills\RapidFire;
use App\Domain\Skills\SkillInterface;

class BattleService implements BattleServiceInterface
{
    // Lupta are maxim 15 ture conform cerintei.
    private const MAX_TURNS = 15;

    // Istoricul luptelor generate in aceasta instanta de service.
    private array $battleHistory = [];

    // Id-ul urmator care va fi atribuit unei lupte.
    private int $nextBattleId = 1;

    // Simuleaza intreaga lupta dintre erou si monstru.
    public function simulate(Character $hero, Character $monster): Battle
    {
        // Alegem cine ataca primul si cine se apara primul.
        [$attacker, $defender] = $this->determineFirstAttacker($hero, $monster);

        // Pregatim lista de log-uri pentru ture.
        $logs = [];

        // Parcurgem turele de la 1 pana la maximul permis.
        for ($turn = 1; $turn <= self::MAX_TURNS; $turn++) {
            // Daca unul dintre personaje nu mai traieste, oprim lupta.
            if (!$hero->isAlive() || !$monster->isAlive()) {
                // Iesim din bucla de ture.
                break;
            }

            // Executam atacul curent si salvam rezultatul in log.
            $logs[] = $this->attack($turn, $attacker, $defender);

            // Schimbam rolurile pentru tura urmatoare.
            [$attacker, $defender] = [$defender, $attacker];
        }

        // Construim entitatea Battle cu rezultatul final.
        $battle = new Battle(
            // Salvam eroul dupa lupta.
            $hero,
            // Salvam monstrul dupa lupta.
            $monster,
            // Calculam castigatorul final.
            $this->determineWinner($hero, $monster),
            // Salvam numarul real de ture jucate.
            count($logs),
            // Salvam log-urile fiecarei ture.
            $logs
        );

        // Atribuim un id simplu luptei.
        $battle->setId($this->nextBattleId++);

        // Salvam lupta in istoricul local.
        $this->battleHistory[$battle->getId()] = $battle;

        // Returnam obiectul Battle final.
        return $battle;
    }

    // Returneaza toate luptele simulate pana acum.
    public function getBattleHistory(): array
    {
        // Folosim array_values ca sa returnam lista fara chei interne.
        return array_values($this->battleHistory);
    }

    // Returneaza o lupta dupa id.
    public function getBattleById(int $id): ?Battle
    {
        // Daca id-ul exista, returnam lupta; altfel returnam null.
        return $this->battleHistory[$id] ?? null;
    }

    // Decide cine incepe lupta.
    private function determineFirstAttacker(Character $hero, Character $monster): array
    {
        // Daca vitezele sunt egale, folosim luck-ul ca departajare.
        if ($hero->getSpeed() === $monster->getSpeed()) {
            // Cine are luck mai mare incepe primul.
            return $hero->getLuck() >= $monster->getLuck()
                // Daca eroul are luck mai mare sau egal, el ataca primul.
                ? [$hero, $monster]
                // Altfel monstrul ataca primul.
                : [$monster, $hero];
        }

        // Daca vitezele sunt diferite, cine are speed mai mare incepe.
        return $hero->getSpeed() > $monster->getSpeed()
            // Eroul ataca primul daca este mai rapid.
            ? [$hero, $monster]
            // Monstrul ataca primul daca este mai rapid.
            : [$monster, $hero];
    }

    // Executa o tura de atac.
    private function attack(int $turn, Character $attacker, Character $defender): array
    {
        // Lista cu intamplarile textuale ale turei.
        $events = [];

        // Lista cu skill-urile folosite in aceasta tura.
        $usedSkills = [];

        // Damage-ul total facut in aceasta tura.
        $totalDamage = 0;

        // Stabilim daca atacatorul loveste o data sau de doua ori.
        $numberOfHits = $this->getNumberOfHits($attacker, $usedSkills);

        // Adaugam in log faptul ca atacatorul incepe atacul.
        $events[] = $attacker->getName() . ' attacks ' . $defender->getName() . '.';

        // Rulam fiecare lovitura din aceasta tura.
        for ($hit = 1; $hit <= $numberOfHits; $hit++) {
            // Daca defenderul a murit dupa o lovitura anterioara, oprim atacul.
            if (!$defender->isAlive()) {
                // Iesim din bucla loviturilor.
                break;
            }

            // Verificam daca defenderul are noroc si evita lovitura.
            if ($this->isLucky($defender)) {
                // Notam in log ca lovitura a fost evitata.
                $events[] = $defender->getName() . ' got lucky and avoided hit #' . $hit . '.';

                // Trecem la urmatoarea lovitura fara damage.
                continue;
            }

            // Calculam damage-ul brut: strength atacator minus defence defender.
            $damage = max(0, $attacker->getStrength() - $defender->getDefence());

            // Aplicam eventualele skill-uri defensive, cum este Magic Armour.
            $damage = $this->applyDefenceSkills($defender, $damage, $usedSkills);

            // Scadem damage-ul final din viata defenderului.
            $defender->takeDamage($damage);

            // Adunam damage-ul la totalul turei.
            $totalDamage += $damage;

            // Notam in log damage-ul produs de aceasta lovitura.
            $events[] = $attacker->getName() . ' dealt ' . $damage . ' damage on hit #' . $hit . '.';
        }

        // Returnam structura de log pentru aceasta tura.
        return [
            // Numarul turei curente.
            'turn' => $turn,

            // Numele personajului care a atacat.
            'attacker' => $attacker->getName(),

            // Numele personajului care s-a aparat.
            'defender' => $defender->getName(),

            // Intamplarile descrise textual.
            'events' => $events,

            // Skill-urile activate in tura.
            'skills_used' => $usedSkills,

            // Damage-ul total facut in tura.
            'damage' => $totalDamage,

            // Health-ul ramas defenderului dupa tura.
            'defender_health_left' => $defender->getHealth(),
        ];
    }

    // Stabileste cate lovituri face atacatorul.
    private function getNumberOfHits(Character $attacker, array &$usedSkills): int
    {
        // Parcurgem skill-urile atacatorului.
        foreach ($attacker->getSkills() as $skill) {
            // Cautam doar RapidFire si verificam daca se poate activa la atac.
            if (!$skill instanceof RapidFire || !$this->canUseSkill($skill, SkillInterface::TYPE_ATTACK)) {
                // Daca skill-ul nu este potrivit, trecem mai departe.
                continue;
            }

            // Salvam skill-ul folosit in lista de log.
            $usedSkills[] = $skill->getName();

            // RapidFire inseamna doua lovituri in tura.
            return 2;
        }

        // Fara RapidFire activ, atacatorul loveste o singura data.
        return 1;
    }

    // Aplica skill-urile defensive peste damage.
    private function applyDefenceSkills(Character $defender, int $damage, array &$usedSkills): int
    {
        // Parcurgem skill-urile defenderului.
        foreach ($defender->getSkills() as $skill) {
            // Cautam doar MagicArmour si verificam daca se poate activa la aparare.
            if (!$skill instanceof MagicArmour || !$this->canUseSkill($skill, SkillInterface::TYPE_DEFENCE)) {
                // Daca skill-ul nu este potrivit, continuam cautarea.
                continue;
            }

            // Salvam skill-ul folosit in lista de log.
            $usedSkills[] = $skill->getName();

            // MagicArmour injumatateste damage-ul primit.
            return (int) ceil($damage / 2);
        }

        // Daca nu s-a activat niciun skill defensiv, damage-ul ramane neschimbat.
        return $damage;
    }

    // Verifica tipul skill-ului si sansa de activare.
    private function canUseSkill(SkillInterface $skill, string $expectedType): bool
    {
        // Skill-ul este valid doar daca are tipul corect si se activeaza random.
        return $skill->getType() === $expectedType && $skill->activates();
    }

    // Verifica daca defenderul evita lovitura prin luck.
    private function isLucky(Character $defender): bool
    {
        // Daca numarul random este sub luck, lovitura este ratata.
        return (random_int(1, 100) / 100) <= $defender->getLuck();
    }

    // Determina castigatorul final.
    private function determineWinner(Character $hero, Character $monster): ?string
    {
        // Daca eroul traieste si monstrul nu, eroul castiga.
        if ($hero->isAlive() && !$monster->isAlive()) {
            // Returnam numele eroului.
            return $hero->getName();
        }

        // Daca monstrul traieste si eroul nu, monstrul castiga.
        if ($monster->isAlive() && !$hero->isAlive()) {
            // Returnam numele monstrului.
            return $monster->getName();
        }

        // Daca amandoi au acelasi health dupa 15 ture, este egalitate.
        if ($hero->getHealth() === $monster->getHealth()) {
            // Returnam null pentru egalitate.
            return null;
        }

        // Daca nu a murit nimeni, castiga cel cu health mai mare.
        return $hero->getHealth() > $monster->getHealth()
            // Eroul castiga daca are health mai mare.
            ? $hero->getName()
            // Monstrul castiga daca are health mai mare.
            : $monster->getName();
    }
}
