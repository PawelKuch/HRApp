<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'leaveId',
        'userId',
        'fromDate',
        'toDate',
        'leaveStatus'
    ];

    public function user() : belongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
    ];
}
