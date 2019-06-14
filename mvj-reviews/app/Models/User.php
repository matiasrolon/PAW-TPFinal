<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
USE App\Models\Range;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    public function roles(){
      return $this->belongsToMany('App\Models\Role', 'user_role', 'user_id', 'role_id');
    }

    public function range()
    {
        return $this->belongsTo('App\Models\Range');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'email', 'password','username','fecha_nacim','biografia',
        'genero_fav','pelicula_fav','serie_fav','avatar','puntos','estado',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
     {
        parent::boot();

        self::saving(function ($user) {
              $puntos = $user->puntos;
              $rango = Range::where('puntaje_desde',$puntos)->first();
              if (($rango!=null)&&($user->range_id != $rango->id)){
                $user->range_id = $rango->id;
              }
            }
        );

        self::creating(function ($user) {
               $user->puntos = 0;
               $user->estado = 'activo';
               $user->range_id = Range::where('nombre','Principiante')->first()->id;
               //$user->avatar = file_get_content(IMAGEN POR DEFECTO);
               //$user->biografia = "Aun no tienes biografia"; //  ???????
            }
         );

    }
}
