<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Models\Kin;
use App\Models\Familiar;
use App\Models\Gaian;

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
            ->paginate(15, ['*'], 'kin_page', null)
            ->withQueryString();

        $familiars = QueryBuilder::for(Familiar::class)
            ->with(['gaian', 'colourist', 'species'])
            ->join('gaians as colourist', 'familiars.colourist_id', '=', 'colourist.id')
            ->join('gaians as owner', 'familiars.owner_id', '=', 'owner.id')
            ->join('familiar_species as species', 'familiars.familiar_species_id', '=', 'species.id')
            ->allowedFilters(['name'])
            ->select('familiars.*', 'species.name as species_name')
            ->paginate(15, ['*'], 'familiar_page', null)
            ->withQueryString();

        $owners = QueryBuilder::for(Gaian::class)
            ->allowedIncludes('kin', 'familiar')
            ->with('kin', 'familiar')
            ->withCount('kin', 'familiar')
            ->allowedFilters(['name'])
            ->paginate(15, ['*'], 'owner_page', null)
            ->withQueryString();


        return inertia('Index', [
            'kin' => $kin,
            'familiars' => $familiars,
            'owners' => $owners,
        ]);
    }

    public function search()
    {
    }
}
