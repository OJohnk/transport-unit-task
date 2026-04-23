<?php

namespace Database\Seeders;

use App\Models\TransportUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransportUnitSeeder extends Seeder
{
    public function run(): void
	{
		TransportUnit::factory()->count(50000)->create(['type' => 'truck']);
		TransportUnit::factory()->count(50000)->create(['type' => 'trailer']);
	}
}
