<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BattleLog extends Model
{
    //Ce salvam la fiecare tura:
    protected $fillable = [
        'battle_id', 'turn_number', 'attacker', 'defender',
        'damage', 'defender_health_left', 'description', 'skills_used'
    ];

    //nu poti salva direct un array PHP de genul ['Rapid fire', 'Magic armour'] intr-o singura coloana. Datele trebuie salvate ca text (de obicei in format JSON)
    protected $casts = [
        'skills_used' => 'array',
    ];

    //relatia inversa
    public function battle()
    {
        return $this->belongsTo(Battle::class);
    }
}
