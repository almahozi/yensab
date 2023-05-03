<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Task;
use App\Models\Team;
use Illuminate\Validation\Rule;

class CreateTaskRequest extends FormRequest
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
        $team = Team::find($this->team);
        return [
            'title'         =>  'required|string',
            'dueDate'       =>  'nullable|date',
            'description'   =>  'required|string',
            'assignee'      =>  ['required', 'integer',
                                // Assignee must be either team owner or team member.
                                // The 'when' rule can be found here: https://github.com/laravel/framework/pull/38361 
                                Rule::when($this->assignee != $team->owner->id,
                                    Rule::exists('team_user', 'user_id')->where(function ($query) use ($team) {
                                        return $query->where('team_id', $team->id);
                                    })
                                )
                            ]
        ];
    }
}
