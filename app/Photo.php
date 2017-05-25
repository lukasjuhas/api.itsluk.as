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
        'trip_id',
        'title',
        'caption',
        'preview',
        'thumb',
        'url',
        'order',
        'size',
        'orientation',
        'data',
        'status'
    ];

    /**
     * ptoho belongs to a trip
     *
     * @return collection
     */
    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    /**
     * get data attribute
     *
     * @param mixed $data
     * @return mixed
     */
    public function getDataAttribute($data)
    {
        $photoDataTransformer = app(\Transformers\PhotoDataTransformer::class);
        return $photoDataTransformer->transform($data);
    }
}
