<?php

namespace Tests\Feature;

use Carbon\Carbon;
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
        $this->signIn();

        $threads = create("App\Thread", ['user_id'=>auth()->id()]);
        
        $this->get("/profiles/". auth()->user()->name)
            ->assertSee($threads->tittle)
            ->assertSee($threads->body);
    }
}
