<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'slug',
    ];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function ads()
    {
        return $this->hasManyThrough(Ad::class, Department::class);
    }
} 