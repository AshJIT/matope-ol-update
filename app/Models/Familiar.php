<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Familiar extends Model
{
    use HasFactory;
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'current_image_url',
        'cert_url',
        'familiar_species_id',
        'kin_id',
        'owner_id',
        'colourist_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function kin() {
        return $this->belongsTo(Kin::class, 'kin_id');
    }

    public function gaian() {
        return $this->belongsTo(Gaian::class, 'owner_id');
    }

    public function colourist() {
        return $this->belongsTo(Gaian::class, 'colourist_id');
    }

    public function species() {
        return $this->belongsTo(FamiliarSpecies::class, 'familiar_species_id');
    }
}
