<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title', 'description', 'user_id', 'start_time', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class)->withDefault();
    }
}
