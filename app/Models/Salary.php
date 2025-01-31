<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salary extends Model
{
    use HasFactory;
    protected $fillable = ['employee_id','amount'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
