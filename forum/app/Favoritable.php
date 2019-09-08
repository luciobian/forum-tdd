<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Trait Favoritable
 * 
 * Operaciones para el modelo Favorite.
 */
trait Favoritable
{
    /**
     * Relación polimórfica.
     *
     * @return void
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * Verifica que pueda poner en favorito solo una vez.
     *
     * @return void
     */
    public function favorite()
    {
        $atributte = ['user_id'=>auth()->id()];
        if(!$this->favorites()->where($atributte)->exists()){
            return $this->favorites()->create($atributte);
        }
    }

    /**
     * Determina que un usuario no hay puesto favorito.
     *
     * @return boolean
     */
    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    /**
     * Retorna la cantidad de favoritos.
     *
     * @return int
     */    
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
