<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Provisiona um usuário administrador para demonstração local.
 *
 * Execute com:
 *   php artisan db:seed --class=AdminSeeder
 *
 * ATENÇÃO: use apenas em ambiente de desenvolvimento.
 * Nunca exponha este e-mail/senha em produção.
 */
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Cria (ou atualiza) o usuário admin pelo e-mail
        $user = User::updateOrCreate(
            ['email' => 'admin@redepatas.local'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('Admin@1234'),
            ]
        );

        // Garante que o perfil seja admin — atualiza se já existir
        Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'type'        => 'admin',
                'description' => 'Perfil administrativo — provisionado via seeder',
            ]
        );

        $this->command->info("Admin provisionado: admin@redepatas.local / Admin@1234");
    }
}
