<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function componentsAndMaterials() {
        return view('pages.material');
    }

    public function productionPlanning(){
        return view('pages.production_planning');
    }
}
