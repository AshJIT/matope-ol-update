<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Kin;
use Spatie\QueryBuilder\QueryBuilder;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $kin = QueryBuilder::for(Kin::class)
        ->with(['gaian', 'colourist'])
        ->allowedFilters(['name'])
        ->allowedSorts(['name', 'email'])
        ->defaultSort('id')
        ->paginate(15)
        ->withQueryString();

        return inertia('SearchIndex', [
            'kin' => $kin,
        ]);
    }

    public function search() {

    }
}
