<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Type extends Model
{
    protected $fillable = [
        'title', 'description',
    ];

    // LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
    // since the plural of user isnt what we named our database table we have to define it
    protected $table = 'type';


    // DEFINE RELATIONSHIPS --------------------------------------------------

    public function topic() {
        return $this->hasMany('Topic');
    }


}
