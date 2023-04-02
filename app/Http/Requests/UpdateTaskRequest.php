<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Task;
use App\Models\Team;
use App\Support\Constant;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->task);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $statuses = array_column(Constant::STATUSES, 'name');
        return [
            'title'     =>  'required|string',
            'dueDate'   =>  'nullable|date',
            'status'    =>  'required', Rule::in($statuses)
        ];
    }
}
