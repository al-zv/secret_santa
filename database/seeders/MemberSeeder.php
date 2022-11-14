<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MemberSeeder extends Seeder
{
    /**
     * Заполняются 40 участников, для формирования имени, профессии
     *  и желаемого подарка примяется функция random класса Str 
     * (заполняются случайным символьно-цифровым набором).
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 40; $i++) {
            DB::table('members')->insert([
                'name' => Str::random(5),
                'profession' => Str::random(8),
                'desired_gift' => Str::random(10),
            ]);
        }
    }
}
