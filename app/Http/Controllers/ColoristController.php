<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gaian;
use App\Models\Kin;
use App\Models\Gender;
use App\Models\KinSpecies;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class ColoristController extends Controller
{
    public function index($slug)
    {
        $kin = QueryBuilder::for(Kin::class)
        ->whereHas('colourist', function($query) use ($slug) {
            $query->where('slug', $slug);
        })->with(['gaian', 'colourist', 'gender', 'species'])
        ->join('gaians as colourist', 'kin.colourist_id', '=', 'colourist.id')
        ->join('genders as gender', 'kin.gender_id', '=', 'gender.id')
        ->join('gaians as owner', 'kin.owner_id', '=', 'owner.id')
        ->join('kin_species as species', 'kin.species_id', '=', 'species.id')
        ->select('kin.*', 'species.name as species_name')
        ->allowedFilters(['name', 'colourist.name', 'gaian.name'])
        ->allowedSorts('kin.name', 'kin.birthdate', 'colourist.name', 'gender.name', 'owner.name', 'species.name')
        ->paginate()
        ->withQueryString();

        return inertia('Colorist', [
            'kin' => $kin
        ]);
    }
}
