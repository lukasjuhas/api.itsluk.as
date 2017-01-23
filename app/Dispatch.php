<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dispatch extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'title', 'content', 'status',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    protected $table = 'dispatches';

    public function tags()
    {
        return $this->belongsToMany(Tag::class); 
    }
}
