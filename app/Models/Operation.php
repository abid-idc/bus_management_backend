<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'operation_employees')->withTimestamps();
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
