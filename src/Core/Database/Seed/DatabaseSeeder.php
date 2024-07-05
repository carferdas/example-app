<?php

namespace App\Core\Database\Seed;

use App\User\Database\Seed\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function __construct() {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);
    }
}
