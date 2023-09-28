<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionPlanController extends Controller
{
    public function getCarComponents()
    {
        $res = DB::table('car_components')
            ->leftJoin('components', 'components.id', '=', 'car_components.component_id')
            ->select('car_components.*', 'components.name', 'components.stock', 'components.production_cost', 'components.production_time')->get();

        return $res;
    }

    public function saveSimulationHistories(){
            
    }
}
