<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'current_image_url',
        'mother_id',
        'father_id',
        'species_id',
        'current_kin_phase_id',
        'owner_id',
        'colourist_id',
        'birthdate',
        'created_at',
        'updated_at',
        'gender_id',
        'children_count'
    ];

    public function gaian() {
        return $this->belongsTo(Gaian::class, 'owner_id');
    }

    public function colourist() {
        return $this->belongsTo(Gaian::class, 'colourist_id');
    }

    public function gender() {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function species() {
        return $this->belongsTo(KinSpecies::class, 'species_id');
    }

    public function mother() {
        return $this->belongsTo(Kin::class, 'mother_id');
    }

    public function father() {
        return $this->belongsTo(Kin::class, 'father_id');
    }
}
