<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class CarComponentController extends Controller
{
    public function insertCar(Request $request)
    {
        try {
            $id = Uuid::uuid4();
            $carName = $request->post('carName');
            $components = $request->post('component');

            DB::table('car')->insert([
                'id' => $id,
                'name' => $carName
            ]);

            $carComponents = [];

            for ($i = 0; $i < count($components); $i++) {
                $x = [
                    'id' => Uuid::uuid4(),
                    'car_id' => $id,
                    'raw_components_id' => $components[$i]['component_id'],
                    'raw_component_qty' => $components[$i]['component_qty']
                ];

                array_push($carComponents, $x);
            }

            DB::table('car_components')->insert($carComponents);

            return('Success!');
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
