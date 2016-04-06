<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{
    protected $fillable = [
        'content',
    ];

    // LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
    // since the plural of user isnt what we named our database table we have to define it
    protected $table = 'comment';

    // DEFINE RELATIONSHIPS --------------------------------------------------

    public function topic() {
        return $this->belongsTo('App\Topic');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

}
