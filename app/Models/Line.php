<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function depart()
    {
        return $this->belongsTo(City::class, 'depart_city_id');
    }

    public function arrival()
    {
        return $this->belongsTo(City::class, 'arrival_city_id');
    }

}
