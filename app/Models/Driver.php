<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $casts = ['cnh:string'];

    /**
     * @var string[]
     */
    protected $fillable = ['cnh'];

    /**
     * @return HasMany
     */
    public function passengers(): HasMany {
        return $this->hasMany(Passengers::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
