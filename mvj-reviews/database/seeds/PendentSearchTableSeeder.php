<?php

use Illuminate\Database\Seeder;
use App\Models\PendentSearch;

class PendentSearchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(PendentSearch::class, 20)->create();

    }
}
