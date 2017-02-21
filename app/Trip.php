<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'location', 'date_string', 'feature', 'content', 'upcoming', 'status'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    protected $table = 'trips';
}
