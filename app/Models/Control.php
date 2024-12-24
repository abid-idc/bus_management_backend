<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    use HasFactory;

    protected $guarded = [
        "id",
        "created_at",
        "updated_at"
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class, 'bus_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function line()
    {
        return $this->belongsTo(Line::class, 'line_id');
    }
}
