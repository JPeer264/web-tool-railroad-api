<?php

namespace App;


use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    JWTSubject
{
    use SoftDeletes, Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'gender', 'picture_alt',
        'company_id', 'job_id', 'role_id',
        'picture_location', 'email', 'country_id', 'city',
        'address', 'signup_comment', 'birthday', 'Facebook',
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
    protected $table = 'User';

    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function company() {
        return $this->hasOne('App\Company');
    }

    public function country() {
        return $this
            ->hasOne('App\Country', 'id', 'country_id')
            ->select('id', 'name');
    }

    public function role() {
        return $this->hasOne('App\Role');
    }

    public function job() {
        return $this->hasOne('App\Job', 'id', 'job_id');
   }

   public function topic() {
       return $this->hasMany('App\Topic');
   }

   public function comment() {
       return $this->hasMany('App\Comment');
   }

   /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
