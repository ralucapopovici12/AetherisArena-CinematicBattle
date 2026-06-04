<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Battle extends Model
{
    protected $fillable = ['hero_name', 'monster_name', 'winner_name', 'turns_played'];
    
    public function logs()
    {
        return $this->hasMany(BattleLog::class);
    }
}
