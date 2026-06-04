<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Battle;
use App\Models\BattleLog;

class BattleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_simulate_battle_via_api()
    {
        // 1. Apelam endpoint-ul de simulare a luptei
        $response = $this->getJson('/api/battle/simulate');

        // 2. Verificam ca statusul HTTP este 200 (OK)
        $response->assertStatus(200);

        // 3. Verificam structura raspunsului JSON
        $response->assertJsonStructure([
            'battle_id',
            'hero' => [
                'name',
                'max_health',
                'strength',
                'defence',
                'speed',
                'luck',
            ],
            'monster' => [
                'name',
                'max_health',
                'strength',
                'defence',
                'speed',
                'luck',
            ],
            'winner',
            'turns',
            'logs' => [
                '*' => [
                    'turn',
                    'attacker',
                    'defender',
                    'damage',
                    'defender_health_left',
                    'events',
                    'skills_used',
                ]
            ]
        ]);

        // 4. Verificam salvarea in baza de date (tabela battles)
        $this->assertDatabaseCount('battles', 1);
        
        $battle = Battle::first();
        $this->assertEquals('Kratos', $battle->hero_name);
        $this->assertEquals('Wild Monster', $battle->monster_name);
        
        // 5. Verificam salvarea log-urilor pe ture in baza de date (tabela battle_logs)
        $this->assertGreaterThanOrEqual(1, BattleLog::count());
        
        $firstLog = BattleLog::where('battle_id', $battle->id)->first();
        $this->assertNotNull($firstLog);
        $this->assertEquals(1, $firstLog->turn_number);
    }
}
