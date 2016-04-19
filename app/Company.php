<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'administrator', 'name', 'logo_alt', 'logo_location',
        'country_id', 'city', 'address', 'phonenumber', 'email',

    ];

    // LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
    // since the plural of user isnt what we named our database table we have to define it
    protected $table = 'company';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function category() {
        return $this->belongsToMany('App\Category', 'Category_Company', 'category_id', 'company_id');
    }

    public function country() {
        return $this
            ->hasOne('App\Country', 'id', 'country_id')
            ->select('id', 'name');
    }

    public function topic() {
        return $this->belongsToMany('App\Topic', 'Topic_Company', 'topic_id', 'company_id');
    }

    public function user() {
        return $this->hasMany('App\User');
    }

    public function administrator() {
        return $this->hasOne('App\User', 'user_id','administrator');
    }
}
