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
        $this->signIn();

        $thread = create("App\Thread");

        $reply = make("App\Reply");

        $this->post($thread->path()."/replies", $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    function aReplyRequiresABody()
    {
        $this->withExceptionHandling()->signIn();

        $reply = make("App\Reply", ['body'=>null]);
        $thread = create("App\Thread");

        $this->post($thread->path()."/replies", $reply->toArray())
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function anuthorizedUserCanNotDeleteReplies()
    {
        $this->withExceptionHandling();

        $reply = create("App\Reply");

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect("/login");

        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    function anAuthorizedUserCanDeleteThreads()
    {
        $this->signIn();

        $reply = create("App\Reply", ["user_id" => auth()->id()]);

        $this->delete("/replies/{$reply->id}")
            ->assertStatus(302);
        $this->assertDatabaseMissing('replies', $reply->toArray());
    }

    /** @test */
    function anuthorizedUserCanNotUpdateReplies()
    {
        $this->withExceptionHandling();

        $reply = create("App\Reply");

        $this->patch("/replies/{$reply->id}")
            ->assertRedirect("/login");

        $this->signIn()
            ->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    function anAuthorizedUserCanUpdateAReply()
    {
        $this->signIn();

        $reply = create("App\Reply", ["user_id" => auth()->id()]);
        $updatedReply = "You been changed, fool.";
        $this->patch("/replies/{$reply->id}", ["body" => $updatedReply]);
        $this->assertDatabaseHas('replies', ['id'=>$reply->id, 'body'=>$updatedReply]);
    }
}
