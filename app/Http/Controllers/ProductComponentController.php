<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ProductComponentController extends Controller
{
    public function insertRawComponents(Request $request) {
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

            return('Success');
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
