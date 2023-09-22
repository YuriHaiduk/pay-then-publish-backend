<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create([
            'name' => 'Bronze',
            'price' => 50,
            'amount' => 5,
            'is_active' => true
        ]);

        Plan::create([
            'name' => 'Silver',
            'price' => 100,
            'amount' => 10,
            'is_active' => true
        ]);

        Plan::create([
            'name' => 'Gold',
            'price' => 150,
            'amount' => 15,
            'is_active' => false
        ]);
    }
}
