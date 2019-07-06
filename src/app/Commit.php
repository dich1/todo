<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commit extends Model
{
    protected $fillable = [
        'name', 'user_id', 'group_id', 'limit'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function commitGroups()
    {
        return $this->hasMany('App\CommitGroup');
    }
}
