<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'purpose',
        'frequency',
        'active',
        'sort_order',
    ];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}


