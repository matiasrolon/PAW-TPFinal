<?php

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $genre = new Genre();
      $genre->nombre = "Acción";
      $genre->save();
      $genre = new Genre();
      $genre->nombre = "Ciencia ficción";
      $genre->save();
      $genre = new Genre();
      $genre->nombre = "Comedia";
      $genre->save();
      $genre = new Genre();
      $genre->nombre = "Drama";
      $genre->save();
      $genre = new Genre();
      $genre->nombre = "Fantasía";
      $genre->save();
      $genre = new Genre();
      $genre->nombre = "Melodrama";
      $genre->save();
      $genre = new Genre();
      $genre->nombre = "Musical";
      $genre->save();
      $genre = new Genre();
      $genre->nombre = "Romance";
      $genre->save();
      $genre = new Genre();
      $genre->nombre = "Suspenso";
      $genre->save();
      $genre = new Genre();
      $genre->nombre = "Terror";
      $genre->save();
    }
}
