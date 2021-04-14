<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Kin;

class KinController extends Controller
{
    public function show($slug)
    {
        $kin = Kin::where('slug', $slug)->with(['gaian', 'colourist', 'gender', 'mother', 'father'])->first();

        return inertia('Kin', [
            'kin' => $kin,
            'slug' => $slug
        ]);
    }
}
