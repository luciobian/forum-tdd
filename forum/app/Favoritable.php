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
     * Pone en favorito a un comentario.
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
     * Quita el favorito a un comentario.
     *
     * @return void
     */
    public function unfavorite()
    {
        $atributte = ['user_id'=>auth()->id()];
        $this->favorites()->where($atributte)->delete();
    }

    /**
     * Determina que un usuario haya o no puesto favorito.
     *
     * @return boolean
     */
    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    /**
     * Retorna como atributo el método isFavorited().
     *
     * @return boolean
     */
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
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
