<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class File extends Model
{

    protected $fillable = [
        'comment_id', 'path', 'filepath', 'filename', 'isimage'
    ];

    // LINK THIS MODEL TO OUR DATABASE TABLE ---------------------------------
    // since the plural of user isnt what we named our database table we have to define it
    protected $table = 'File';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    // DEFINE RELATIONSHIPS --------------------------------------------------

    public function Comment() {
        return $this->belongsTo('App\Comment');
    }

}
