<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\User;
use App\Models\Team;
use App\Models\Task;
use App\Models\Attachment;

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

    public function test_tasks_can_be_reassigned_in_updates()
    {
        $owner = User::factory()->hasOwnedTeams(1)->create();
        $this->actingAs($owner);
        $team = $owner->ownedTeams()->first();
        $user = User::factory()->create();
        $team->users()->attach($user);
        $task = Task::factory()->recycle($owner)
            ->recycle($team)
            ->create();

        $this->assertEquals($owner->id, $task->fresh()->assignee->id);

        $response = $this->post(route('updates.store', $task), [
            'message'   => 'This is a message',
            'assignee'  => $user->id
        ]);

        $this->assertCount(1, $task->fresh()->updates);
        $this->assertEquals($user->id, $task->fresh()->assignee->id);
    }

    public function test_attachments_can_be_uploaded_with_updates()
    {
        $owner = User::factory()->hasOwnedTeams(1)->create();
        $this->actingAs($owner);
        $team = $owner->ownedTeams()->first();
        $user = User::factory()->create();
        $team->users()->attach($user);
        $task = Task::factory()->recycle($owner)
            ->recycle($team)
            ->create();

        //Storage::fake('local');
        $files = [UploadedFile::fake()->create('document1.pdf'), UploadedFile::fake()->create('document2.pdf')];

        $response = $this->post(route('updates.store', $task), [
            'message'   => 'This is a message.',
            'assignee'  => NULL,
            'files'     => $files
        ]);

        $response->assertStatus(302);

        $update = $task->updates->first();
        $attachments = Attachment::where('update_id', $update->id)->get();

        foreach($attachments as $attachment)
        {
            Storage::disk('local')->assertExists($attachment->url);
        }
    }
}
