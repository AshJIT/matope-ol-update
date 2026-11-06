<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

use App\Models\Kin;

class Gaian extends Model
{
    use HasFactory;
    use Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $table = 'gaians';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'is_colourist',
        'user_id',
        'kin_count',
        'coloured_kin_count'
    ];

    public function kin()
    {
        return $this->hasMany(Kin::class, 'owner_id');
    }

    public function familiar()
    {
        return $this->hasMany(Familiar::class, 'owner_id');
    }
}
