<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable
     * 
     * @var string[]
     */
    protected $fillable = [
        'id',
        'center_id',
        'customer_id',
        'total_service_cost',
        'is_closed',
        'is_delivered',
        'delivered_at',
        'delivery_location',
        'is_payment_due',
        'opened_by',
        'opened_at',
        'due_at',
        'closed_by',
        'closed_at',
        'serviced_by',
        'issue_count',
        'open_issue',
        'closed_issue',
    ];

    /**
     * The attributes excluded from the model's JSON form
     * 
     * @var string[]
     */
    protected $hidden = [];
}
