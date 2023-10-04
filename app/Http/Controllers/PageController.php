<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function componentsAndMaterials() {
        return view('pages.material')->with('materialIsActive', 'active')->with('ppIsActive', '')->with('ccIsActive', '')->with('pcIsActive', '');
    }

    public function productionPlanning(){
        return view('pages.production_planning')->with('materialIsActive', '')->with('ppIsActive', 'active')->with('ccIsActive', '')->with('pcIsActive', '');
    }

    public function carComponent(){
        return view('pages.car_component')->with('materialIsActive', '')->with('ppIsActive', '')->with('ccIsActive', 'active')->with('pcIsActive', '');
    }

    public function productComponent(){
        return view('pages.product_component')->with('materialIsActive', '')->with('ppIsActive', '')->with('ccIsActive', '')->with('pcIsActive', 'active');
    }
}
