<?php

use Illuminate\Database\Seeder;
use App\Models\Nominee;

class NomineeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Nominee::class, 100)->create();
    }
}
