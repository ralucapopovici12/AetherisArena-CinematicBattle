<?php

namespace Database\Seeders;
//functioneaza mana in mana cu folderul factories
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Sau generam 10 utilizatori complet random folosind factory-ul
        // User::factory(10)->create();

        // Cream un utilizator de test fix, ca sa stim cu ce sa ne logam
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
