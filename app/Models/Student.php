<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [
        'id'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
