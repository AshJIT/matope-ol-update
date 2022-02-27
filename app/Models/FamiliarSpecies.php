<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamiliarSpecies extends Model
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

    public function familiar() {
        return $this->hasOne(Familiar::class);
    }
}
