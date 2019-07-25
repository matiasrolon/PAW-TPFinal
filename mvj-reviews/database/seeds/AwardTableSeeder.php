<?php

use Illuminate\Database\Seeder;
use App\Models\Award;

class AwardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            factory(Award::class, 5)->create();
    }
}
