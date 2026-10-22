<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\StoreFamiliar;
use App\Models\Kin;
use App\Models\Familiar;
use App\Models\Gender;
use App\Models\FamiliarSpecies;
use App\Models\Gaian;

class FamiliarController extends Controller
{
    public function index()
    {
        return inertia('FamiliarList', [
            'familiars' => Familiar::with(['gaian', 'species', 'colourist', 'kin'])->paginate()
        ]);
    }

    public function show($slug)
    {
        $familiar = Familiar::where('slug', $slug)->with(['gaian', 'kin', 'colourist', 'species'])->first();

        return inertia('Familiar', [
            'familiar' => $familiar,
        ]);
    }

    public function create(Request $request) 
    {
        return inertia('Admin/Familiar/Create', [
            'familiar_species' => FamiliarSpecies::when($request->familiar_species, function($query, $familiar_species) {
                $query->where('name', 'LIKE', $familiar_species . '%');
            })->orderBy('name', 'asc')->paginate(),
            'owners' => Gaian::when($request->owner, function($query, $owner) {
                $query->where('name', 'LIKE', $owner . '%');
            })->orderBy('name', 'asc')->paginate(),
            'kin' => Kin::when($request->kin, function($query, $kin) {
                $query->where('name', 'LIKE', $kin . '%');
            })->orderBy('name', 'asc')->paginate(),
            'colorist' => Gaian::where('is_colourist', 1)->when($request->colorist, function($query, $colorist) {
                $query->where('name', 'LIKE', $colorist . '%');
            })->orderBy('name', 'asc')->paginate(),
        ]);
    }

    public function edit(Request $request, $id) 
    {
        return inertia('Admin/Familiar/Edit', [
            'familiar' => Familiar::where('id', $id)->with(['gaian', 'kin', 'colourist', 'species'])->first(),
            'familiar_species' => FamiliarSpecies::when($request->familiar_species, function($query, $familiar_species) {
                $query->where('name', 'LIKE', $familiar_species . '%');
            })->orderBy('name', 'asc')->paginate(),
            'owners' => Gaian::when($request->owner, function($query, $owner) {
                $query->where('name', 'LIKE', $owner . '%');
            })->orderBy('name', 'asc')->paginate(),
            'kin' => Kin::when($request->kin, function($query, $kin) {
                $query->where('name', 'LIKE', $kin . '%');
            })->orderBy('name', 'asc')->paginate(),
            'colorist' => Gaian::where('is_colourist', 1)->when($request->colorist, function($query, $colorist) {
                $query->where('name', 'LIKE', $colorist . '%');
            })->orderBy('name', 'asc')->paginate(),
        ]);
    }

    public function store(StoreFamiliar $request) 
    {
        Familiar::create($request->validated());

        return Redirect::route('admin.familiar.create')->with('flash.banner', 'Familiar record created successfully!');
    }

    public function update(StoreFamiliar $request, Familiar $familiar)
    {
        $familiar->fill($request->validated());

        $familiar->save();
        
        return Redirect::back()->with('flash.banner', 'Familiar updated successfully!');
    }
}
