<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Expense extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'expenses';

    /**
     * The attributes that are mass assignable
     * 
     * @var string[]
     */
    protected $fillable = [
        'id',
        'ticket_id',
        'item_name',
        'cost',
        'created_at',
        'created_by'
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
        static::creating(function ($expense) {
            $expense->{$expense->getKeyName()} = (string) Str::orderedUuid();
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
