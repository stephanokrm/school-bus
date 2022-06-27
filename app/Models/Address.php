<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'number',
        'complement',
        'neighborhood',
        'street',
        'zip_code',
        'external_city_id',
    ];

    /**
     * @var string[]
     */
    public $casts = [
        'external_city_id:integer',
        'zip_code:string',
    ];
}
