<?php

namespace App;

use App\Thread;
use App\Activity;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Modelo usuario.
 * 
 * Contiene operaciones y relaciones de usuario.
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    /**
     * Retorna el Key del modelo.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'name';
    }

    /**
     * Relación con threads.
     *
     * @return void
     */
    public function threads () 
    {
        return $this->hasMany(Thread::class)->latest();
    }

    /**
     * Relación con activities.
     *
     * @return void
     */
    public function activity(){
        return $this->hasMany(Activity::class);
    }
}
