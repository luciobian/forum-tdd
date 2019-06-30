<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guestsMayNotCreateAThreads()
    {
        $this->withExceptionHandling();
        
        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');            
    }

    /** @test */
    function anAuthenticatedUserCanCreateNewForumThreads()
    {
        $this->singIn();

        // raw crea un arreglo del factory
        // make crea una instacia pero no guarda en db
        // create guarda en db lo que crea el factory
        $thread = create('App\Thread');
        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->body)
            ->assertSee($thread->title);
    }
    
}
