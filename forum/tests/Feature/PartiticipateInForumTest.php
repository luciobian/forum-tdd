<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PartiticipateInForumTest extends TestCase
{
    use DatabaseMigrations;


    /** @test */
    function unauthenticatedUserMayNotAddReplies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        
        $this->post("threads/1/replies", []);

    }

    /** @test */
    function anAuthenticatedUserMayParticipateInForumThreads()
    {
        $this->be($user = factory("App\User")->create());

        $thread = factory("App\Thread")->create();

        $reply = factory("App\Reply")->make();

        $this->post($thread->path()."/replies", $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
