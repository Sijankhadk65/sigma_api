<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Expense extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Visible in JSON form
     * @var string[]
     */
    protected $fillable = [];

    /**
     * Hidden from JSON form
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
}
