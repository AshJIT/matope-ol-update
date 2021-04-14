<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Kin;
use App\Models\Gaian;

class OwnerController extends Controller
{
    public function index($slug)
    {
        $kin = Kin::with('gaian', 'colourist')
        ->whereHas('gaian', function($query) use ($slug) {
            $query->where('slug', $slug); 
        })->paginate(15);

        $owner = Gaian::where('slug', $slug)->first();

        return inertia('Owner', [
            'kin' => $kin,
            'owner' => $owner
        ]);
    }
}
