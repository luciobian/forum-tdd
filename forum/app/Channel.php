<?php

namespace App;

use App\Thread;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Channel
 * 
 * Contiene operaciones y relaciones de los canales de las publicaciones.
 */
class Channel extends Model
{

    /**
     * Define el la clave primaria del Modelo.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Relación con las publicaciones.
     *
     * @return void
     */
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
