<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gaian;
use App\Models\Kin;
use App\Models\Gender;
use App\Models\KinSpecies;

class ColoristController extends Controller
{
    public function index($slug)
    {
        $kin = Kin::whereHas('colourist', function($query) use ($slug) {
            $query->where('slug', $slug);
        })->with('gaian', 'colourist')->paginate();

        return inertia('Colorist', [
            'kin' => $kin
        ]);
    }
}
