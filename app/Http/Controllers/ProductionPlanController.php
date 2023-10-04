<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionPlanController extends Controller
{
    // public function getCarComponents()
    // {
    //     $res = DB::table('raw_components')
    //         ->select('*')->get();

    //     return $res;
    // }

    public function getCarComponents()
    {
        $carComponents = DB::table('raw_components')->select('*')->get();

        return $carComponents;
    }

    function getChildComponents(Request $request, $parentId) {
        $rawComponents = DB::table('raw_components')
            ->leftJoin('component_has_other_component', 'component_has_other_component.child_component_id', '=', 'raw_components.id')
            ->where('component_has_other_component.parent_component_id', $parentId)
            ->select('raw_components.name')
            ->get();

        return $rawComponents;
    }
}
