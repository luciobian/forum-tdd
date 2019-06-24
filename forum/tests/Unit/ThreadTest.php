<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp():void
    {
        parent::setUp();

        $this->thread = factory("App\Thread")->create();
    }

    /** @test */
    function aThreadHasReplies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /** @test */
    function aThreadHasACreator()
    { 
        $this->assertInstanceOf( 'App\User', $this->thread->creator);
    }

    /** @test */
    function aThreadCanAddAReply()
    {
        $this->thread->addReplay([
            "body"=>"Foo",
            "user_id"=>1
        ]);
        $this->assertCount(1,$this->thread->replies);
    }
}
