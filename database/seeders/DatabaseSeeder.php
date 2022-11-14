<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Гланый сидер запускает заполение таблиц участников и подопечных.
     *
     * @return void
     */
    public function run()
    {
        $this->call([MemberSeeder::class]);
        $this->call([SecretSantaSeeder::class]);
    }
}
