<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Team;
use App\Models\Task;

class CreateUpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_updates_can_be_created()
    {
        $owner = User::factory()->hasOwnedTeams(1)->create();
        $this->actingAs($owner);
        $team = $owner->ownedTeams()->first();
        $user = User::factory()->create();
        $team->users()->attach($user);
        $task = Task::factory()->recycle($owner)
            ->recycle($team)
            ->create();

        $response = $this->post(route('updates.store', $task), [
            'message'   => 'This is a message',
            'assignee'  => NULL
        ]);

        $this->assertCount(1, $task->fresh()->updates);
        $this->assertEquals('This is a message', $task->fresh()->updates()->first()->message);

    }
}
