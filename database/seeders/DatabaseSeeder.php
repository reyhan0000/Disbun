<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin DISBUN',
            'email' => 'admin@disbun.test',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Operator DISBUN',
            'email' => 'operator@disbun.test',
            'role' => 'operator',
        ]);

        User::factory()->create([
            'name' => 'Kepala Bidang',
            'email' => 'kabid@disbun.test',
            'role' => 'kabid',
        ]);

        User::factory()->create([
            'name' => 'Kebun Harapan',
            'email' => 'pekebun@disbun.test',
            'role' => 'kelompok_tani',
        ]);
    }
}
