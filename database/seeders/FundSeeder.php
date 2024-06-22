<?php

namespace Database\Seeders;

use App\Models\Fund;
use Illuminate\Database\Seeder;

final class FundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Fund::factory(5)->create();
    }
}
