<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Job extends Model
{
    protected $fillable = [
        'title', 'description',
    ];

    // LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
    // since the plural of user isnt what we named our database table we have to define it
    protected $table = 'Job';

    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function category() {
        return $this->belongsToMany('App\Category', 'Category_Job', 'category_id', 'job_id');
    }

    public function topic() {
        return $this->belongsToMany('App\Topic', 'Topic_Job', 'topic_id', 'job_id');
    }

    public function user() {
        return $this->hasMany('App\User');
    }
}
