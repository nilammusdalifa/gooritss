<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionPlanController extends Controller
{
    public function getCarComponents()
    {
        $res = DB::table('components')
            ->select('*')->get();

        return $res;
    }

    public function saveSimulationHistories(){

    }
}
