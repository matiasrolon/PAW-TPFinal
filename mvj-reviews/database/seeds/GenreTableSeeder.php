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

      // Algunos nuevos que estan en la API
      /* Si quieren sacar alguno, comentenlo, no lo borren. Y avisenme asi acomodo la API */
      $genre = new Genre();
      $genre->nombre = 'Aventura';
      $genre->save();

      $genre = new Genre();
      $genre->nombre = 'Animado';
      $genre->save();

      $genre = new Genre();
      $genre->nombre = 'Crimen';
      $genre->save();

      $genre = new Genre();
      $genre->nombre = 'Documental';
      $genre->save();

      $genre = new Genre();
      $genre->nombre = 'Familia';
      $genre->save();

      $genre = new Genre();
      $genre->nombre = 'Historia';
      $genre->save();

      $genre = new Genre();
      $genre->nombre = 'Misterio';
      $genre->save();

      $genre = new Genre();
      $genre->nombre = 'Bélica';
      $genre->save();

      $genre = new Genre();
      $genre->nombre = 'Western';
      $genre->save();
    }
}
