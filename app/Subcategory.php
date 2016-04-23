<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Subcategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'category_id'
    ];

    // LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
    // since the plural of user isnt what we named our database table we have to define it
    protected $table = 'Subcategory';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function topic() {
        return $this->hasMany('App\Topic');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }


}
