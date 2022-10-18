<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'transactions';

    protected $casts = [
        'amount' => 'float'
    ];

    /**
     * The attributes that are mass assignable
     * 
     * @var string[]
     */
    protected $fillable = [
        'id',
        'created_at',
        'created_by',
        'transaction_at',
        'type',
        'source',
        'description',
        'amount'
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
        static::creating(function ($transaction) {
            $transaction->{$transaction->getKeyName()} = (string) Str::uuid();
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
