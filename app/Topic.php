<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Topic extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'subcategory_id', 'user_id', 'type_id', 'title', 'description'
    ];

    // LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
    // since the plural of user isnt what we named our database table we have to define it
    protected $table = 'Topic';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function company() {
        return $this->belongsToMany('App\Company', 'Topic_Company', 'topic_id', 'company_id');
    }

    public function job() {
        return $this->belongsToMany('App\Job', 'Topic_Job', 'topic_id', 'job_id');
    }

    public function comment() {
        return $this->hasMany('App\Comment');
    }


    public function subcategory() {
        return $this->belongsTo('App\Subcategory');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function type() {
        return $this->belongsTo('App\Type');
    }
}
