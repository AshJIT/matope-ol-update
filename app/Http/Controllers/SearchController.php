<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Kin;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $kin = Kin::when($request->name, function($query, $name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        })->with(['gaian', 'colourist'])->orderBy('name', 'asc')->paginate()->withQueryString();

        return inertia('Index', [
            'kin' => $kin
        ]);
    }

    public function search() {

    }
}
