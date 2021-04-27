<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Models\Kin;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $kin = QueryBuilder::for(Kin::class)
            ->with(['gaian', 'colourist', 'gender', 'species'])
            ->join('gaians as colourist', 'kin.colourist_id', '=', 'colourist.id')
            ->join('genders as gender', 'kin.gender_id', '=', 'gender.id')
            ->join('gaians as owner', 'kin.owner_id', '=', 'owner.id')
            ->join('kin_species as species', 'kin.species_id', '=', 'species.id')
            ->select('kin.*', 'species.name as species_name')
            ->allowedFilters(['name', 'colourist.name', 'owner.name'])
            ->allowedSorts('kin.name', 'kin.birthdate', 'colourist.name', 'gender.name', 'owner.name', 'species.name')
            ->paginate()
            ->withQueryString();

        return inertia('Index', [
            'kin' => $kin
        ]);
    }

    public function search() {

    }
}
