<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Center extends Model
{

    public $timestamps = false;
    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'id',
        'name',
        'address',
        'contact',
        'email',
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [];

    /**
     * Boot function for setting triggers
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($center) {
            $center->{$center->getKeyName()} = (string) Str::uuid();
        });
    }

    /**
     * $incrementing = false
     */
    public function getIncrementing()
    {
        return false;
    }


    /**
     * $keyType = 'string'
     */
    public function getKeyType()
    {
        return 'string';
    }
}
