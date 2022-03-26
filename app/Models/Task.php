<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * Get task creator.
     */
    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get task owners.
     */
    public function owners()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the user currently assigned to the task.
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    /**
     * Get task's team.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
