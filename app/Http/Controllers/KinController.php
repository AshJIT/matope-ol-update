<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\StoreKin;
use App\Models\Kin;
use App\Models\Gender;
use App\Models\KinSpecies;
use App\Models\Gaian;
use App\Models\Familiar;

class KinController extends Controller
{
    public function show($slug)
    {
        $kin = Kin::where('slug', $slug)->with(['gaian', 'colourist', 'gender', 'mother', 'father', 'species'])->first();

        return inertia('Kin', [
            'kin' => $kin,
            'children' => Kin::with(['mother', 'father'])->where('father_id', $kin->id)->orWhere('mother_id', $kin->id)->get(),
            'familiars' => Familiar::where('kin_id', $kin->id)->get()
        ]);
    }

    public function create(Request $request)
    {
        return inertia('Admin/Kin/Create', [
            'gender' => fn () => Gender::all(),
            'species' => fn () => KinSpecies::all(),
            'mothers' => fn () => Kin::when($request->mom, function ($query, $mom) {
                $query->where('name', 'LIKE', $mom . '%');
            })->orderBy('name', 'asc')->simplePaginate(),
            'fathers' => fn () => Kin::when($request->dad, function ($query, $dad) {
                $query->where('name', 'LIKE', $dad . '%');
            })->orderBy('name', 'asc')->simplePaginate(),
            'owners' => fn () => Gaian::when($request->owner, function ($query, $owner) {
                $query->where('name', 'LIKE', $owner . '%');
            })->orderBy('name', 'asc')->simplePaginate(),
            'colorist' => fn () => Gaian::where('is_colourist', 1)->orderBy('name', 'asc')->get()
        ]);
    }

    public function edit(Request $request, $id)
    {
        return inertia('Admin/Kin/Edit', [
            'kin' => fn () => Kin::where('id', $id)->with(['gender', 'gaian', 'colourist', 'species', 'mother', 'father'])->first(),
            'gender' => fn () => Gender::all(),
            'species' => fn () => KinSpecies::all(),
            'mothers' => fn () => Kin::when($request->mom, function ($query, $mom) {
                $query->where('name', 'LIKE', $mom . '%');
            })->orderBy('name', 'asc')->simplePaginate(),
            'fathers' => fn () => Kin::when($request->dad, function ($query, $dad) {
                $query->where('name', 'LIKE', $dad . '%');
            })->orderBy('name', 'asc')->simplePaginate(),
            'owners' => fn () => Gaian::when($request->owner, function ($query, $owner) {
                $query->where('name', 'LIKE', $owner . '%');
            })->orderBy('name', 'asc')->simplePaginate(),
            'colorist' => fn () => Gaian::where('is_colourist', 1)->orderBy('name', 'asc')->get()
        ]);
    }

    public function store(StoreKin $request)
    {
        Kin::create($request->validated());

        return Redirect::route('admin.kin.create')->with('flash.banner', 'Kin created successfully!');
    }

    public function update(StoreKin $request, Kin $kin)
    {
        $kin->fill($request->validated());

        $kin->save();

        return Redirect::back()->with('flash.banner', 'Kin updated successfully!');
    }
}
