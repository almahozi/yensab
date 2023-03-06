<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class CreateTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_tasks_can_be_created()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $team = $user->personalTeam();

        $response = $this->post(route('tasks.store', $team), [
            'title'       =>  'Test Task',
            'dueDate'     => date('Y-m-d'),
            'assignee'    =>  $user->id,
            'description' =>  'This is a test task!',
        ]);

        $this->assertCount(1, $team->fresh()->tasks);
        $this->assertEquals('Test Task', $team->fresh()->tasks()->latest('id')->first()->title);
    }
}
