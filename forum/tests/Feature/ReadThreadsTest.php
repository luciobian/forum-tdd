<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp():void
    {
        parent::setUp();
        $this->thread = create("App\Thread");
    }

    /** @test*/
    public function aUserCanSeeAllThreads()
    {        
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function aUserCanSeeASingleThread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /** @test */

    public function aUserCanReadRepliesThatAreAssocieatedWithAThread()
    {
        $reply = create("App\Reply",["thread_id"=>$this->thread->id]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    function aUserCanFilterThreadsAccordingToAChannel()
    {
        $channel = create("App\Channel");
        $threadInChannel = create("App\Thread", ['channel_id'=>$channel->id]);
        $threadNotInChannel = create("App\Thread");

        $this->get('/threads/'.$channel->slug)
            ->assertSee($threadInChannel->tittle)
            ->assertDontSee($threadNotInChannel);

    }

    /** @test */
    function aUserCanFilterThreadsByAnyUsername()
    {
        $this->signIn(create("App\User",['name'=>'lucio']));

        $threadByLucio = create("App\Thread", ["user_id"=> auth()->id()]);

        $threadByOtherUser = create("App\Thread");

        $this->get('/threads?by=lucio')
            ->assertSee($threadByLucio->title)
            ->assertDontSee($threadByOtherUser->title);
    }
}
