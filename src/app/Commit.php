<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commit extends Model
{
    protected $fillable = [
        'name', 'user_id', 'limit'
    ];

    protected $appends = [
        'commit_groups'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function commitGroups()
    {
        return $this->hasMany('App\CommitGroup');
    }

    public function getCommitGroupsAttribute()
    {
        return $this->commitGroups()
            ->getResults();
    }
}
