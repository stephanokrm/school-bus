<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Route extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'order',
        'passenger_id',
        'school_id'
    ];

    /**
     * @var string[]
     */
    public $casts = ['order:integer'];

    /**
     * @return BelongsTo
     */
    public function passenger(): BelongsTo {
        return $this->belongsTo(Passenger::class);
    }

    /**
     * @return BelongsTo
     */
    public function school(): BelongsTo {
        return $this->belongsTo(School::class);
    }
}
