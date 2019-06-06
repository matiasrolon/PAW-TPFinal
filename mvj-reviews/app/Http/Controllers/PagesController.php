<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    // Ejemplo
    public function prueba () 
    {
        $arreglo = ['esto' => 'Estos son datos', 'datos' => 'Pasados como arreglo a la vista.'];
        return view('prueba', ['titulo' => 'Toma por curioso', 'varName' => $arreglo]);
    }
}
