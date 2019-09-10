<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guestCanNotFavoriteAnything()
    {
        $this->withExceptionHandling() 
            ->post("/replies/1/favorites")
            ->assertRedirect('/login');
    }
    
    /** @test */
    function anAutenticatedUserCanFavoriteAnyReply()
    {
        $this->signIn();
        $reply = create("App\Reply");

        $this->post("/replies/".$reply->id."/favorites");
        
        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    function anAuthenticatedUserCanOnlyFavoriteAReplyOnce()
    {
        $this->signIn();
        $reply = create("App\Reply");

        try {
            //code...
            $this->post("/replies/".$reply->id."/favorites");
            $this->post("/replies/".$reply->id."/favorites");
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record set twice.');
        }


        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    function anAutenticatedUserCanUnfavoriteAReply()
    {
        $this->signIn();

        $reply = create("App\Reply");

        $reply->favorite();

        $this->delete("/replies/".$reply->id."/favorites");
        
        $this->assertCount(0, $reply->favorites);
    }
}
