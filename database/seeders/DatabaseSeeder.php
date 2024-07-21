<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Sekretariat;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'id' => 1,
            'role_id' => 1,
            'name' => 'Admin Sekretariat',
            'email' => 'sekre.admin@akademik.edu',
            'username' => '111111111111',
            'salt' => 'Ablahum123',
            'password' => bcrypt('Ablahum123')
        ]);

        Sekretariat::create([
            'user_id' => 1,
            'nip' => '111111111111',
            'email' => 'sekre.admin@akademik.edu',
            'nama_sekretariat' => 'Lelouch Lamperouge',
            'telepon' => '0888888888888'
        ]);
    }
}
