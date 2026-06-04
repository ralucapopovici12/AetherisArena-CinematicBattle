<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\BattleService;
use App\Domain\Factories\CharacterFactory;
use App\Models\Battle as BattleModel;

class BattleController extends Controller
{
    public function simulate(BattleService $battleService)
    {
        $factory = new CharacterFactory();
        $kratos = $factory->createKratos();
        $monster = $factory->createMonster();

        // Salvam viata initiala inainte ca personajele sa lupte si sa fie afectate
        $kratosInitialHealth = $kratos->getHealth();
        $monsterInitialHealth = $monster->getHealth();

        $battleEntity = $battleService->simulate($kratos, $monster);

        $battleRecord = BattleModel::create([
            'hero_name' => $kratos->getName(),
            'monster_name' => $monster->getName(),
            'winner_name' => $battleEntity->getWinner(),
            'turns_played' => $battleEntity->getTurns(),
        ]);

        foreach ($battleEntity->getLogs() as $logData) {
            $battleRecord->logs()->create([
                'turn_number' => $logData['turn'],
                'attacker' => $logData['attacker'],
                'defender' => $logData['defender'],
                'damage' => $logData['damage'],
                'defender_health_left' => $logData['defender_health_left'],
                'description' => implode(' ', $logData['events']),
                'skills_used' => $logData['skills_used'],
            ]);
        }

        return response()->json([
            'battle_id' => $battleRecord->id,
            'hero' => [
                'name' => $kratos->getName(),
                'max_health' => $kratosInitialHealth,
                'strength' => $kratos->getStrength(),
                'defence' => $kratos->getDefence(),
                'speed' => $kratos->getSpeed(),
                'luck' => $kratos->getLuck() * 100,
            ],
            'monster' => [
                'name' => $monster->getName(),
                'max_health' => $monsterInitialHealth,
                'strength' => $monster->getStrength(),
                'defence' => $monster->getDefence(),
                'speed' => $monster->getSpeed(),
                'luck' => $monster->getLuck() * 100,
            ],
            'winner' => $battleEntity->getWinner(),
            'turns' => $battleEntity->getTurns(),
            'logs' => $battleEntity->getLogs(),
        ]);
    }
}
