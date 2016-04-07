<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'gender', 'picture_alt',
        'picture_location', 'email', 'country', 'city',
        'address', 'signup_comment', 'birthday', 'Twitter',
        'Twitter', 'LinkedIn', 'Xing',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    // LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
    // since the plural of user isnt what we named our database table we have to define it
    protected $table = 'user';

    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function company() {
        return $this->belongsTo('App\Company');
    }

    public function role() {
        return $this->belongsTo('App\Role');
    }

    public function job() {
        return $this->belongsTo('App\Job');
   }

   public function topic() {
       return $this->hasMany('App\Topic');
   }

   public function comment() {
       return $this->hasMany('App\Comment');
   }

}
