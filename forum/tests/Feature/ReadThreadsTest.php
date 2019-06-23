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
        $this->thread = factory("App\Thread")->create();
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
        $this->get("/threads/".$this->thread->id)
            ->assertSee($this->thread->title);
    }

    /** @test */

    public function aUserCanReadRepliesThatAreAssocieatedWithAThread()
    {
        $reply = factory("App\Reply")
            ->create(["thread_id"=>$this->thread->id]);

        $this->get("/threads/".$this->thread->id)
            ->assertSee($reply->body);
    }
}
