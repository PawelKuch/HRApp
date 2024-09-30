<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin \Illuminate\Database\Query\Builder
 */


class Expense extends Authenticatable
{
    use HasFactory;

    protected $fillable =[
        'expenseId',
        'userdId',
        'invoiceNo',
        'value',
        'date',
        'category',
        'description',
        'status',
    ];

    public function user() : belongsTo {
        return $this->belongsTo(User::class);
    }
}
