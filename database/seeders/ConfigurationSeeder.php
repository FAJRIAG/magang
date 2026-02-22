<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Configuration::create([
            'key' => 'cooldown_seconds',
            'value' => '10',
            'description' => 'Minimum seconds between taps for same card'
        ]);

        \App\Models\Configuration::create([
            'key' => 'daily_limit',
            'value' => '2',
            'description' => 'Maximum rewards per employee per day'
        ]);

        \App\Models\Configuration::create([
            'key' => 'pulse_duration',
            'value' => '3000',
            'description' => 'Duration (ms) to activate relay'
        ]);
    }
}
