<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Service\BattleService;
use App\Domain\Factories\CharacterFactory;
use App\Domain\Entities\Battle;

class BattleServiceTest extends TestCase
{
    public function test_it_can_simulate_a_battle()
    {
        $factory = new CharacterFactory();
        $kratos = $factory->createKratos();
        $monster = $factory->createMonster();

        $service = new BattleService();
        $battle = $service->simulate($kratos, $monster);

        $this->assertInstanceOf(Battle::class, $battle);
        $this->assertTrue($battle->getTurns() <= 15);
        $this->assertIsArray($battle->getLogs());
    }
}
