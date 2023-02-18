<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get update attachments.
     * 
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
