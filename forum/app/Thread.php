<?php

namespace App;
use App\Channel;
use App\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    use RecordsActivity;

    protected $guarded=[];

    protected $with = ['creator', 'channel'];
   

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

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function creator() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReplay($reply)
    {
        $this->replies()->create($reply);

        return back();
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query, $filter)
    {
        return $filter->apply($query);
    }
}
