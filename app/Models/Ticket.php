<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
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
        'pay_recieved_by',
        // 'is_delivered',
        'paid_at',
        // 'delivery_location',
        'is_payment_due',
        'opened_by',
        'opened_at',
        // 'due_at',
        'closed_by',
        'closed_at',
        'serviced_by',
        'issue_count',
        'open_issue',
        'closed_issue',
        'device_manufacturer',
        'device_model',
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
        static::creating(function ($ticket) {
            $ticket->{$ticket->getKeyName()} = IdGenerator::generate(['table' => 'tickets', 'length' => 8, 'prefix' => 'MCE-']);
            // $ticket->{$ticket->getKeyName()} = (string) Str::orderedUuid();
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

    /** 
     * Gets the Issues asscoiated with the ticket
     */
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    /**
     * Get the Worker associated with the Ticket 
     */
    public function worker()
    {
        return $this->belongsTo(Worker::class, 'serviced_by');
    }

    /**
     * Get the Expenses asscoicated with the Ticket
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
