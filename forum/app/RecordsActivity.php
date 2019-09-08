<?php

namespace App;

/**
 * Trait RecordsActivity.
 */
trait RecordsActivity
{
    /**
     * Determina el tipo de actividad para crearla.
     *
     * @return void
     */
    protected static function bootRecordsActivity()
    {

        if(auth()->guest()) return ;

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function($model) use ($event){
                $model->recordActivity('created');
            });

        }
        static::deleting(function ($model){
            $model->activity()->delete();
        });

    }

    /**
     * Determina el tipo de actividad.
     *
     * @return void
     */
    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }
    
    /**
     * Crea una nueva actividad de usuario.
     *
     * @param [type] $event
     * @return void
     */
    protected function recordActivity($event)
    {
        $this->activity()->create([
            'type' => $this->getActivityType($event),
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * Relación polimórfica.
     *
     * @return void
     */
    protected function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    /**
     * Obtiene el tipo de actividad.
     *
     * @param [type] $event
     * @return string
     */
    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());

        return "{$event}_{$type}" ;
    }
}
