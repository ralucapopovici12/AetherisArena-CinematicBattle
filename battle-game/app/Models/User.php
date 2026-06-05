<?php

namespace App\Models;


use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Extind Authenticatable pentru a oferi modelului functiile native de autentificare (logare, parole, sesiuni)
class User extends Authenticatable
{
    // hasFactory permite generarea de date false pentru teste
    // Notifiable permite primirea de notificari
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */


    //Doar coloanele trecute in acest array au voie sa fie salvate "la gramada" prin comenzi de genul User::create($request->all()).
    // Orice alt camp trimis din greseala sau cu intentie va fi ignorat pt siguranta.
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */

    //Atunci cand Laravel transforma acest obiect intr-un JSON, campurile din acest array vor fi ascunse automat.
    protected $hidden = [
        'password',
        'remember_token',
    ];


    //'email_verified_at' => 'datetime': Transforma string-ul de tip text din baza de date intr-un obiect special de tip data/ora,
    // ca sa poti face operatii matematice cu el
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
