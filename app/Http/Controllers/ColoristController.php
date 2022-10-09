<?php

namespace App\Http\Controllers;

use App\Models\Kin;
use App\Models\Familiar;
use App\Models\Gaian;
use Spatie\QueryBuilder\QueryBuilder;

class ColoristController extends Controller
{
    public function index($slug)
    {
        $kin = QueryBuilder::for(Kin::class)
            ->whereHas('colourist', function ($query) use ($slug) {
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

        $familiars = QueryBuilder::for(Familiar::class)
            ->whereHas('colourist', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })->with(['gaian', 'colourist', 'species'])
            ->paginate(15, ['*'], 'familiar_page', null)
            ->withQueryString();

        $colorist = Gaian::where('slug', $slug)->first();

        return inertia('Colorist', [
            'kin' => $kin,
            'familiars' => $familiars,
            'colorist' => $colorist
        ]);
    }
}
