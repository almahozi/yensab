<?php

namespace App\Http\Controllers;

use App\Models\Update;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUpdateRequest;
use App\Models\Task;

class UpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUpdateRequest $request, Task $task)
    {
        $data = $request->validated();
        $update = Update::create([
            'message'       => $data['message'],
            'task_id'       => $task->id,
            'user_id'       => $request->user()->id,
            'assignee_id'   => $data['assignee']
        ]);

        if(isset($data['assignee']))
        {
            $task->assignee()->associate($data['assignee']);
            $task->save();
        }
        

        return redirect()->route('tasks.show', [$task->team, $task]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Update  $update
     * @return \Illuminate\Http\Response
     */
    public function show(Update $update)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Update  $update
     * @return \Illuminate\Http\Response
     */
    public function edit(Update $update)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Update  $update
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Update $update)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Update  $update
     * @return \Illuminate\Http\Response
     */
    public function destroy(Update $update)
    {
        //
    }
}
