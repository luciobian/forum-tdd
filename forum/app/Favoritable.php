<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 */
trait Favoritable
{
    
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }
    public function favorite()
    {
        $atributte = ['user_id'=>auth()->id()];
        if(!$this->favorites()->where($atributte)->exists()){
            return $this->favorites()->create($atributte);
        }
    }

    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getFavoritesCountAtributte()
    {
        return $this->favorites->count();
    }
}
