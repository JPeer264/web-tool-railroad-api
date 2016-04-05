<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class User extends Model
{
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

    // LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
    // since the plural of user isnt what we named our database table we have to define it
    protected $table = 'user';

    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function company() {
        return $this->belongsTo('Company');
    }

    public function role() {
        return $this->belongsTo('Role');
    }

    public function job() {
        return $this->belongsTo('Job');
   }

   public function topic() {
       return $this->hasMany('Topic');
   }

   public function comment() {
       return $this->hasMany('Comment');
   }

}
