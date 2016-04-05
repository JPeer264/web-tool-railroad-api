<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    protected $fillable = [
        'title', 'description',
    ];

    // LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
    // since the plural of user isnt what we named our database table we have to define it
    protected $table = 'category';

    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function company() {
        return $this->belongsToMany('Company', 'Category_Company', 'category_id', 'company_id');
    }

    public function job() {
        return $this->belongsToMany('Job', 'Category_Job', 'category_id', 'job_id');
    }

    public function topic() {
        return $this->hasMany('Topic');
    }
}
