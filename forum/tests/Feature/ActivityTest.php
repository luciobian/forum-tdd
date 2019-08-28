<?php

namespace Tests\Feature;

use App\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function itRecordsActivityWhenAThreadIsCreated()
    {
        $this->signIn();

        $thread = create("App\Thread");

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread'
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    function itRecordsActivityWhenAReplyIsCreated()
    {
        $this->signIn();

        create('App\Reply');

        $this->assertEquals(2, Activity::count());
    }
}
