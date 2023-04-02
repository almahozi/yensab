<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;

class EditTaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_tasks_can_be_edited_by_owner()
    {
        $owner = User::factory()->hasOwnedTeams(1)->create();
        $this->actingAs($owner);
        $team = $owner->ownedTeams()->first();
        $task = Task::factory()->recycle($owner)
            ->recycle($team)
            ->create();
        $date = date('Y-m-d');
        $this->patch(route('tasks.update', [$team, $task]), [
            'title' => 'Test Title',
            'status' => 'Done',
            'dueDate' => $date
        ]);

        $task = $task->fresh();

        $this->assertEquals('Test Title', $task->title);
        $this->assertEquals('Done', $task->status);
        $this->assertEquals($date, $task->due_date);
    }

    public function test_tasks_can_be_edited_by_team_admin()
    {
        $owner = User::factory()->hasOwnedTeams(1)->create();
        $team = $owner->ownedTeams()->first();
        $user = User::factory()->create();
        $this->actingAs($user);
        $team->users()->attach($user, ['role' => 'admin']);
        $task = Task::factory()->recycle($owner)
            ->recycle($team)
            ->create();
        $date = date('Y-m-d');
        $this->patch(route('tasks.update', [$team, $task]), [
            'title' => 'Test Title',
            'status' => 'Done',
            'dueDate' => $date
        ]);

        $task = $task->fresh();

        $this->assertEquals('Test Title', $task->title);
        $this->assertEquals('Done', $task->status);
        $this->assertEquals($date, $task->due_date);
    }
}
