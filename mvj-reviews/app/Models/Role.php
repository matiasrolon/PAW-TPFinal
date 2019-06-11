<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

  protected $table = 'role';
  protected $fillable = ['nombre','descripcion',];

  public function users(){
    return $this->belongsToMany('App\Models\User', 'user_role', 'role_id', 'user_id');
  }
}
