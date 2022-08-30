<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'issues';

    /**
     * The attributes that are mass assignable
     * 
     * @var string[]
     */
    protected $fillable = [
        'id',
        'created_at',
        'ticket_id',
        'is_closed',
        'closed_at',
        'description',
    ];

    /**
     * The attributes excluded from the model's JSON form
     * 
     * @var string[]
     */
    protected $hidden = [];
}
