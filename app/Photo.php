<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Transformers\PhotoDataTransformer;

class Photo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'path',
        'url',
        'data',
        'status'
    ];

    public function getDataAttribute($data) {
        $photoDataTransformer = app(\Transformers\PhotoDataTransformer::class);
        return $photoDataTransformer->transform($data);
    }
}
