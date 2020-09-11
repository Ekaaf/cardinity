<?php

use Illuminate\Database\Seeder;
use App\Models\Lang_skill;

class LangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Lang_skill::class, 5)->create();
    }
}
