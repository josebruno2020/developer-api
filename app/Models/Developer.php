<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

/**
 * App\Models\Developer
 *
 * @property string $id
 * @property string $name
 * @property string $sex
 * @property int $age
 * @property string $hobby
 * @property string $birthdate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Developer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Developer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Developer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Developer whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Developer whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Developer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Developer whereHobby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Developer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Developer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Developer whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Developer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Developer extends Model
{
    use HasFactory, SoftDeletes;
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
