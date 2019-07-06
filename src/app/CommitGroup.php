<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommitGroup extends Model
{
    protected $fillable = [
        'content'
    ];

    public function commit()
    {
        return $this->belongsTo('App\Commit');
    }
}
