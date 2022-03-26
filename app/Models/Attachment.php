<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;


    /**
     * Get parent update.
     */
    public function update() 
    {
        return $this->belongsTo(Update::class);
    }
}
