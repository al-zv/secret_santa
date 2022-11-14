<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SecretSantaSeeder extends Seeder
{
    /**
     * Для каждого участника заполняется подопечный:
     * для первого участника выбирается последний подопечный из списка участников
     * и так далее.
     * Стоблец id таблицы подопечные (secret_santas) соответствует 
     * стоблцу id таблицы участников members.
     * Стобец member_id соответствует id подопечному.
     *
     * @return void
     */
    public function run()
    {
        $i = Member::count();
        for ($i; $i > 0; $i--) {
            DB::table('secret_santas')->insert([
                'member_id' => $i,
            ]);
        }
    }
}
