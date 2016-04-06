<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Topic extends Model
{
    protected $fillable = [
        'title', 'description',
    ];

    // LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
    // since the plural of user isnt what we named our database table we have to define it
    protected $table = 'topic';

    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function company() {
        return $this->belongsToMany('App\Company', 'Topic_Company', 'topic_id', 'company_id');
    }

    public function job() {
        return $this->belongsToMany('App\Job', 'Topic_Job', 'top_id', 'job_id');
    }

    public function comment() {
        return $this->hasMany('App\Comment');
    }


    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function type() {
        return $this->belongsTo('App\Type');
    }
}
