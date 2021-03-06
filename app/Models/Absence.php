<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'absent_at',
    ];

    /**
     * @var string[]
     */
    public $casts = ['absent_at:date'];

    /**
     * @return BelongsTo
     */
    public function passenger(): BelongsTo {
        return $this->belongsTo(Passenger::class);
    }
}
