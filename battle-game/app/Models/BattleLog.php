<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BattleLog extends Model
{
    protected $fillable = [
        'battle_id', 'turn_number', 'attacker', 'defender', 
        'damage', 'defender_health_left', 'description', 'skills_used'
    ];
    
    protected $casts = [
        'skills_used' => 'array',
    ];
    
    public function battle()
    {
        return $this->belongsTo(Battle::class);
    }
}
