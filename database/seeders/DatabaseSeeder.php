<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\AdminSeeder;
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
        // Provisiona o administrador de demonstração local
        $this->call(AdminSeeder::class);

        // Cria 20 usuários comuns de exemplo (sem perfil admin)
        User::factory(20)->create();
    }
}
