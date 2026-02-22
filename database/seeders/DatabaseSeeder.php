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
        $this->call([
            ConfigurationSeeder::class,
        ]);

        // User::factory(10)->create();

        // Create Test Device
        \App\Models\Device::create([
            'device_id' => 'VM01',
            'secret_key' => 'secret123',
            'location' => 'Lobby',
        ]);

        // Create Test Employee
        \App\Models\Employee::create([
            'name' => 'John Doe',
            'rfid_uid' => '12345678',
            'reward_balance' => 0,
        ]);

        // Create Test Reward Products
        \App\Models\RewardProduct::create([
            'name' => 'Kopi Susu Gula Aren',
            'type' => 'drink',
            'points_cost' => 50,
            'image_path' => null,
            'stock' => 20,
            'is_active' => true,
        ]);

        \App\Models\RewardProduct::create([
            'name' => 'Ayam Geprek',
            'type' => 'food',
            'points_cost' => 120,
            'image_path' => null,
            'stock' => 15,
            'is_active' => true,
        ]);
    }
}
