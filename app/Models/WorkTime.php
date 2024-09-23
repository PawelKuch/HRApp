<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;


/**
 * @mixin \Illuminate\Database\Query\Builder
 */


class WorkTime extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'userId',
        'startDate',
        'endDate',
        'hoursAmount',
        'date',
    ];
    protected $guarded = [];

    protected $hidden = [];

    protected $casts = [];

    public function user() : belongsTo{
        return $this->belongsTo(User::class);
    }


}
