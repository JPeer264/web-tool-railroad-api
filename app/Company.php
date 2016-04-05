<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Company extends Model
{
    protected $fillable = [
        'administrator', 'name', 'logo_alt', 'logo_location',
        'country', 'city', 'address', 'phonenumber', 'email',

    ];

    // LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
    // since the plural of user isnt what we named our database table we have to define it
    protected $table = 'company';


    // DEFINE RELATIONSHIPS --------------------------------------------------
    // define a many to many relationship
    // also call the linking table
    public function category() {
        return $this->belongsToMany('Category', 'Category_Company', 'category_id', 'company_id');
    }

    public function topic() {
        return $this->belongsToMany('Topic', 'Topic_Company', 'topic_id', 'company_id');
    }

    public function user() {
        return $this->hasMany('User');
    }
}
