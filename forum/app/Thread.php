<?php

namespace App;
use App\Channel;
use App\RecordsActivity;
use Illuminate\Database\Eloquent\Model;


/**
 * Modelo Thread
 * 
 * Contiene operaciones y relaciones de las publicaciones.
 */
class Thread extends Model
{

    use RecordsActivity;

    protected $guarded=[];

    protected $with = ['creator', 'channel'];
   
    /**
     * Función que se ejecuta cuando se llama a la clase. Retorna la cantidad de respuestas que tuvo el thread
     * y elimina las respuestas asociadas cuando se elimina una publicación.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function($builder){
            $builder->withCount('replies');
        });

        static::deleting(function ($thread){
            $thread->replies->each->delete();
        });

    }   

    /**
     * Retorna la ruta de un thread.
     *
     * @return string
     */
    public function path():string
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    /**
     * Relación con replies.
     *
     * @return void
     */
    public function replies(){
        return $this->hasMany(Reply::class);
    }

    /**
     * Relación con usuarios.
     *
     * @return void
     */
    public function creator() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Crea un reply.
     *
     * @param [type] $reply
     * @return void
     */
    public function addReplay($reply)
    {
        $this->replies()->create($reply);

        return back();
    }

    /**
     * Relación con channel.
     *
     * @return void
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * Aplica un filtro de threads.
     *
     * @param [type] $query
     * @param [type] $filter
     * @return void
     */
    public function scopeFilter($query, $filter)
    {
        return $filter->apply($query);
    }
}
