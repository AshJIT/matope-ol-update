<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KinSpecies extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'cert_bg_image_id',
        'created_at',
        'updated_at'
    ];

    public function kin() {
        return $this->hasOne(Kin::class);
    }
}
