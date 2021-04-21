<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Kin;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $kin = Kin::with(['gaian', 'colourist'])->when($request->name, function($query, $name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        })->when($request->owner, function($query, $owner) {
            $query->whereHas('gaian', function($query) use ($owner) {
                $query->where('gaians.name', 'LIKE', '%' . $owner . '%');
            });
        })->orderBy('name', 'asc')->paginate()->withQueryString();

        return inertia('Index', [
            'kin' => $kin
        ]);
    }

    public function search() {

    }
}
