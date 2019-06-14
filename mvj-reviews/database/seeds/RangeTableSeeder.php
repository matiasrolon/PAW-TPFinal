<?php

use Illuminate\Database\Seeder;
use App\Models\Range;

class RangeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $range = new Range();
      $range->nombre = 'Principiante';
      $range->descripcion = 'Critico principiante en el sitio.';
      $range->puntaje_desde= 0;
      $range->puntaje_hasta= 9;
      $range->save();

      $range = new Range();
      $range->nombre = 'Iniciado';
      $range->descripcion = 'Critico iniciado en el sitio, posee cierta experiencia.';
      $range->puntaje_desde= 10;
      $range->puntaje_hasta= 49;
      $range->save();

      $range = new Range();
      $range->nombre = 'Avanzado';
      $range->descripcion = 'Critico Avanzado en el sitio.';
      $range->puntaje_desde= 50;
      $range->puntaje_hasta= 99;
      $range->save();

      $range = new Range();
      $range->nombre = 'Profesional';
      $range->descripcion = 'Critico Profesional en el sitio.';
      $range->puntaje_desde= 100;
      //el ultimo rango no lleva puntaje_hasta
      $range->save();
    }
}
