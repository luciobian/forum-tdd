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
}
