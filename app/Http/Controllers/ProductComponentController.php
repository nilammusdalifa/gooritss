<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ProductComponentController extends Controller
{
    public function insertRawComponents(Request $request)
    {
        try {
            $parentComponentId = $request->post('parentComponentId');
            $componentData = $request->post('rawComponent');
            $rawComponentsHasComponent = [];

            for ($i = 0; $i < count($componentData); $i++) {
                $data = [
                    'id' => Uuid::uuid4(),
                    'parent_component_id' => $parentComponentId,
                    'child_component_id' => $componentData[$i]['child_component_id'],
                    'component_qty' => $componentData[$i]['child_component_qty']
                ];

                array_push($rawComponentsHasComponent, $data);
            }

            DB::table('component_has_other_component')->insert($rawComponentsHasComponent);

            $childComponentIds = DB::table('component_has_other_component')->where('parent_component_id', $parentComponentId)->pluck('child_component_id');
            $productionsTime = [];
            $productionsCost = [];

            for ($i = 0; $i < count($childComponentIds); $i++) {
                $prodTime = DB::table('raw_components')->where('id', $childComponentIds[$i])->value('production_time');
                $prodCost = DB::table('raw_components')->where('id', $childComponentIds[$i])->value('production_cost');
                array_push($productionsTime, $prodTime);
                array_push($productionsCost, $prodCost);
            }
            DB::table('raw_components')->where('id', $parentComponentId)->update([
                'production_time' => array_sum($productionsTime),
                'production_cost' => array_sum($productionsCost)
            ]);

            return ('Success');
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
