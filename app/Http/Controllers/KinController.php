<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\StoreKin;
use App\Models\Kin;
use App\Models\Gender;
use App\Models\KinSpecies;
use App\Models\Gaian;

class KinController extends Controller
{
    public function show($slug)
    {
        $kin = Kin::where('slug', $slug)->with(['gaian', 'colourist', 'gender', 'mother', 'father'])->first();

        $gender = $kin->gender->identifier;

        return inertia('Kin', [
            'kin' => $kin,
            'children' => $gender === 'female' ? Kin::with(['mother', 'father'])->where('mother_id', $kin->id)->get() : Kin::with(['mother', 'father'])->where('father_id', $kin->id)->get()
        ]);
    }

    public function create(Request $request) {

        return inertia('Admin/Kin/Create', [
            'gender' => Gender::all(),
            'species' => KinSpecies::all(),
            'mothers' => Kin::when($request->mom, function($query, $mom) {
                $query->where('name', 'LIKE', $mom . '%');
            })->orderBy('name', 'asc')->paginate(),
            'fathers' => Kin::when($request->dad, function($query, $dad) {
                $query->where('name', 'LIKE', $dad . '%');
            })->orderBy('name', 'asc')->paginate(),
            'owners' => Gaian::when($request->owner, function($query, $owner) {
                $query->where('name', 'LIKE', $owner . '%');
            })->orderBy('name', 'asc')->paginate(),
            'colorist' => Gaian::where('is_colourist', 1)->get()
        ]);
    }

    public function store(StoreKin $request) {

        Kin::create($request->validated());

        return redirect('admin.kin.create')->with('flash.banner', 'Kin created successfully!');
    }
}
