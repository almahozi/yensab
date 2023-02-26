<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Task;
use App\Models\Team;

class createTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Task $task, Team $team)
    {
        return $this->user()->can('create', $team);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'         =>  'required|string',
            'assignee'      =>  'required|integer',
            'dueDate'       =>  'nullable|date',
            'description'   =>  'required|string'
        ];
    }
}
