<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'customers';

    /**
     * The attributes that are mass assignable
     * 
     * @var string[]
     */
    protected $fillable = [
        'id',
        'name',
        'address',
        'ph_number',
    ];

    /**
     * The attributes excluded from the model's JSON form
     * 
     * @var string[]
     */
    protected $hidden = [];

    /**
     * Boot function for setting triggers
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($customer) {
            $customer->{$customer->getKeyName()} = (string) Str::orderedUuid();
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
