<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupplierCategoryEvents;

class CategoryServiceController extends Controller
{
    public function index(Request $request)
    {
        $search_term = $request->input('q');
        $page = $request->input('page');

        if ($search_term)
        {
            $results = SupplierCategoryEvents::where('name', 'LIKE', '%'.$search_term.'%')->paginate(10);
        }
        else
        {
            $results = SupplierCategoryEvents::paginate(10);
        }

        return $results;
    }

    public function show($id)
    {
        return SupplierCategoryEvents::find($id);
    }
}
