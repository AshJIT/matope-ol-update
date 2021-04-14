<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Kin;

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
}
