<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get task creator / author.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
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

    public function updates()
    {
        return $this->hasMany(Update::class);
    }
}
