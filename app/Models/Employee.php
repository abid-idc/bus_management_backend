<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $hidden = ['password'];

    protected $guarded = [
        "id",
        "created_at",
        "updated_at"
    ];

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function operations()
    {
        return $this->belongsToMany(Operation::class, 'operation_employees')->withTimestamps();
    }
}
