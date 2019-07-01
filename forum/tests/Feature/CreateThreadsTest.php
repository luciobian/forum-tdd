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
        $thread = make('App\Thread');
        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->body)
            ->assertSee($thread->title);
    }

    /** @test */
    function aThreadRequiredATitle()
    {
        $this->publishThread(['title'=>null ])
            ->assertSessionHasErrors('title')
        ;
    }

    /** @test */
    function aThreadRequiredABody()
    {
        $this->publishThread(['body'=>null ])
            ->assertSessionHasErrors('body')
        ;
    }

    /** @test */
    function aThreadRequiredAValidChannel()
    {
        factory("App\Channel", 2)->create();
        $this->publishThread(['channel_id'=>null ])
            ->assertSessionHasErrors('channel_id')
        ;

        $this->publishThread(['channel_id'=>999 ])
            ->assertSessionHasErrors('channel_id')
        ;
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->singIn();

        $thread = make("App\Thread", $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
