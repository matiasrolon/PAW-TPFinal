<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FilmCollection extends ResourceCollection
{
    // SACA LA MANO DE AHI CARAJO

    /**
     * Transform the resource collection (que viene en JSON) into an array (para trabajarlo en PHP).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
