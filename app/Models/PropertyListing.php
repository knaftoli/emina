<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'right_move_id',
        'agent',
        'price',
        'address',
        'search_term',
        'uri',
    ];
}
