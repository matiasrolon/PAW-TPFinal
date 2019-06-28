<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(RoleTableSeeder::class);
         $this->call(RangeTableSeeder::class);
         $this->call(UserTableSeeder::class);
         $this->call(GenreTableSeeder::class);
         $this->call(FilmTableSeeder::class);
         $this->call(ScoreFilmTableSeeder::class);
         $this->call(ReviewTableSeeder::class);
         $this->call(ScoreReviewTableSeeder::class);
         $this->call(PendentSearchTableSeeder::class);
    }
}
