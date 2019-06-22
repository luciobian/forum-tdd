<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{

    use DatabaseMigrations;
    /**
     * @test
     */
    public function aUserCanSeeAllThreads()
    {
        $thread = factory('App\Thread')->create();
        
        $response = $this->get('/threads');
        $response->assertSee($thread->title);
    }

    /**
     * @test
     */
    public function aUserCanSeeASingleThread()
    {
        $thread = factory('App\Thread')->create();

        $response = $this->get("/threads/".$thread->id);
        $response->assertSee($thread->title);
    }
}
