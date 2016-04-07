<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'description',
    ];

    // LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
    // since the plural of user isnt what we named our database table we have to define it
    protected $table = 'category';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function company() {
        return $this->belongsToMany('App\Company', 'Category_Company', 'category_id', 'company_id');
    }

    public function job() {
        return $this->belongsToMany('App\Job', 'Category_Job', 'category_id', 'job_id');
    }

    public function topic() {
        return $this->hasMany('App\Topic');
    }
}
