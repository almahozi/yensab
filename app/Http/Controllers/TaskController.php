<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Team;
use App\Models\Update;
use Inertia\Inertia;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Support\Constant;

class TaskController extends Controller
{
    public function index(Request $request, Team $team)
    {
        $this->authorize('viewAny', [Task::class, $team]);
        $tasks = $team->tasks()->with('assignee')->get();
        return Inertia::render('Tasks/Index', [
            'team' => $team,
            'tasks' => $tasks,
            'statuses' => Constant::STATUSES
        ]);

    }

    public function show(Team $team, Task $task)
    {
        $this->authorize('view', $task);
        $updates = $task->updates()->with('user')->with('assignee')->with('attachments')->get();
        $task = Task::where('id', $task->id)->with(['author', 'assignee'])->first();
        $members = $team->allUsers();
        return Inertia::render('Tasks/Show', [
            'task'     => $task,
            'updates'  => $updates,
            'team'     => $team,
            'members'  => $members,
            'statuses' => Constant::STATUSES
        ]);
    }

    public function create(Request $request, Team $team)
    {
        $this->authorize('create', [Task::class, $team]);
        return Inertia::render('Tasks/Create', ['team' => $team, 'members' => $team->allUsers()]);
    }

    public function store(CreateTaskRequest $request)
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
            'task_id' => $task->id,
            'user_id' => $user->id
        ]);

        return redirect()->route('tasks.index', $team);
    }

    public function update(UpdateTaskRequest $request, Team $team, Task $task)
    {
        $data = $request->validated();
        $task->title = $data['title'];
        $task->status = $data['status'];
        $task->due_date = date('Y-m-d', strtotime($data['dueDate']));
        $task->save();

        return redirect()->route('tasks.show', [$task->team, $task]);
    }
}
