<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $team = $request->user()->currentTeam;
        return Inertia::render('Tasks/TaskList', ['team' => $team]);

    }

    public function create(Request $request)
    {

    }
}
