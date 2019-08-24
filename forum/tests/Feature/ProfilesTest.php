<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    function aUserHasAProfile()
    {
        $user = create("App\User");

        $this->get("/profiles/{$user->name}")
            ->assertSee($user->name);
    }

    /** @test */
    function profilesDisplayAllThreadsCreatedByTheAssociatedUser()
    {

        $user = create("App\User");

        $threads = create("App\Thread", ['user_id'=>$user->id]);
        
        $this->get("/profiles/{$user->name}")
            ->assertSee($threads->tittle)
            ->assertSee($threads->body);

    }
}
