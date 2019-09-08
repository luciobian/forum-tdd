<?php

namespace App;

use App\User;
use App\Thread;
use App\Favoritable;
use App\RecordsActivity;
use Illuminate\Database\Eloquent\Model;


/**
 * Modelo Reply
 * 
 * Contiene operaciones y relaciones de las respuestas a las publicaciones.
 */
class Reply extends Model
{

    use Favoritable, RecordsActivity;
    
    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    /**
     * Relación con el modelo usuario.
     *
     * @return void
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con el modelo thread.
     *
     * @return void
     */
    public function  thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * Retorna la ruta de una respuesta a thread.
     *
     * @return string
     */
    public function path():string
    {
        return $this->thread->path() . "#reply-$this->id";
    }

}
