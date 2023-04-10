<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get parent update.
     */
    public function ubdate() // looks like there is already an update method in Illuminate\Database\Eloquent\Model
    {
        return $this->belongsTo(Update::class, 'update_id');
    }
}
