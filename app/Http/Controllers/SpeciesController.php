<?php

namespace App\Http\Controllers;

use App\Models\FamiliarSpecies;
use App\Models\KinSpecies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class SpeciesController extends Controller
{
    private const MODELS = [
        'kin' => KinSpecies::class,
        'familiar' => FamiliarSpecies::class,
    ];

    public function create()
    {
        return inertia('Admin/Species/Create');
    }

    public function store(Request $request)
    {
        $request->validate(['type' => ['required', Rule::in(array_keys(self::MODELS))]]);
        $model = self::MODELS[$request->type];

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique($model, 'name')],
        ]);

        $model::create($data);

        return Redirect::route('admin.species.create')->with('flash.banner', ucfirst($request->type) . ' species created successfully!');
    }
}
