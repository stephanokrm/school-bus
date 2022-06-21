<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Passenger extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    public $casts = ['goes:boolean', 'returns:boolean', 'shift:string'];

    /**
     * @var string[]
     */
    public $with = ['address'];

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
     * @return BelongsTo
     */
    public function responsible(): BelongsTo {
        return $this->belongsTo(User::class, 'responsible_id');
    }
}
