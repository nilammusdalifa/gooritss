<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ComponentMaterialController extends Controller
{
    public function get(){
        $result = DB::table('components')->get();

        return $result;
    }

    public function insert(Request $request) {
        $componentName = $request->post('componentName');
        $componentStock = $request->post('componentStock');
        $cost = $request->post('componentCost');
        $productionTime = $request->post('productionTime');

        try {
            DB::table('components')->insert([
                'id' => Uuid::uuid4(),
                'name' => $componentName,
                'stock' => $componentStock,
                'production_cost' => $cost,
                'production_time' => $productionTime
            ]);

            return('success');
        } catch (\Throwable $th) {
            return $th;
        }

        $materialName = $request->post('materialName');
        $materialStock = $request->post('materialStock');

        try {
            DB::table('raw_materials')->insert([
                'id' => Uuid::uuid4(),
                'name' => $materialName,
                'stock' => $materialStock
            ]);

            return('success');
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
