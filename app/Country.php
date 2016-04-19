<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Country extends Model
{

    protected $fillable = [
        
    ];

    // LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
    // since the plural of user isnt what we named our database table we have to define it
    protected $table = 'Countries';

}
