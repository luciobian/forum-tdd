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
        $this->withExceptionHandling()
            ->post("threads/channel/1/replies", [])
            ->assertRedirect("/login");

    }

    /** @test */
    function anAuthenticatedUserMayParticipateInForumThreads()
    {
        $this->singIn();

        $thread = create("App\Thread");

        $reply = make("App\Reply");

        $this->post($thread->path()."/replies", $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
