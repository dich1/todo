<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommitGroup extends Model
{
    protected $fillable = [
        'content', 'status', 'priority'
    ];

    public function commit()
    {
        return $this->belongsTo('App\Commit');
    }
}
