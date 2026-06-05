<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Battle extends Model //model obisnuit, fara functii de logare sau securitate.
{
    //Acest array protejeaza aplicatia si spune ca o batalie are urmatoarele coloane editabile
    protected $fillable = ['hero_name', 'monster_name', 'winner_name', 'turns_played'];

    //"O singura batalie (Battle) are mai multe inregistrari de istoric (BattleLogs)." relatie intre tabele
    public function logs()
    {
        return $this->hasMany(BattleLog::class);
    }
}
