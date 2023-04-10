<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->belongsToTeam($this->task->team);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $team = $this->task->team;
        return [
            'message'   =>  'required|string',
            'assignee'  =>  ['nullable', 'integer',

                            // Assignee must be either team owner or team member.
                            // The 'when' rule can be found here: https://github.com/laravel/framework/pull/38361
                            Rule::when($this->assignee != $team->owner->id,
                                Rule::exists('team_user', 'user_id')->where(function ($query) use ($team) {
                                    return $query->where('team_id', $team->id);
                                })
                            )],
            'attachments.*' => ['nullable', File::types(['pdf'])]
        ];
    }
}
