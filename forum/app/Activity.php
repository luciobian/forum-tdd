<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Modelo Activity
 * 
 * Contiene operaciones y relaciones de Activity Feed para el profile.
 */
class Activity extends Model
{
    protected $guarded = [];


    /**
     * Relación con el el tipo de activity.
     *
     * @return void
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Retorna el feed de actividadees de un usuario específico.
     *
     * @param User $user
     * @param integer $take
     * @return void
     */
    public static function feed(User $user, int $take = 50)
    {
        return  static::where('user_id', $user->id)
        ->latest()
        ->with('subject')
        ->take($take)
        ->get()
        ->groupBy( function ($activity) {
            return $activity->created_at->format('Y-m-d');
        });
    }
}
