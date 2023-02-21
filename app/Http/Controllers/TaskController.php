<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Team;
use App\Models\Update;
use Inertia\Inertia;
use App\Http\Requests\createTaskRequest;

class TaskController extends Controller
{
    public function index(Request $request, Team $team)
    {
        $this->authorize('viewAny', [Task::class, $team]);
        $tasks = $team->tasks()->with('assignee')->get();
        return Inertia::render('Tasks/TaskList', ['team' => $team, 'tasks' => $tasks]);

    }

    public function create(Request $request)
    {
        $team = $request->user()->currentTeam;
        return Inertia::render('Tasks/Create', ['team' => $team, 'members' => $team->allUsers()]);
    }

    public function store(createTaskRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();
        $team = $request->user()->currentTeam;
        $dueDate = isset($data['dueDate']) ? date('Y-m-d', strtotime($data['dueDate'])) : null;
        $task = Task::create([
            'title'         =>  $data['title'],
            'user_id'       =>  $user->id,
            'assignee_id'   =>  $data['assignee'],
            'team_id'       =>  $team->id,
            'due_date'      =>  $dueDate,
        ]);

        $update = Update::create([
            'message' => $data['description'],
            'task_id' => $task->id
        ]);

        return redirect()->route('tasks.index', $team);
    }
}
