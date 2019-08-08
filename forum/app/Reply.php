<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];


    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

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
}
