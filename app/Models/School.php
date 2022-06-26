<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @var string[]
     */
    public $casts = ['name:string'];

    /**
     * @return BelongsTo
     */
    public function address(): BelongsTo {
        return $this->belongsTo(Address::class);
    }

    /**
     * @return BelongsTo
     */
    public function driver(): BelongsTo {
        return $this->belongsTo(Driver::class);
    }

    /**
     * @return HasMany
     */
    public function passengers(): HasMany {
        return $this->hasMany(Passenger::class);
    }
}
