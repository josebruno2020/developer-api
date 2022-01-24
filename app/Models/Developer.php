<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Developer extends Model
{
    use HasFactory;
    protected $table = 'developers';
    protected $keyType = 'string';
    protected $fillable = [
        'name',
        'sex',
        'age',
        'hobby',
        'birthdate'
    ];

    protected static function booted()
    {
        static::creating(fn(Developer $developer) => $developer->id = (string) Uuid::uuid4());
    }
}
