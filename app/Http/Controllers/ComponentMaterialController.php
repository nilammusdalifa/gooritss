<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ComponentMaterialController extends Controller
{
    public function get()
    {
        $result = DB::table('components')->get();

        return $result;
    }

    public function insertComponent(Request $request)
    {
        $id = Uuid::uuid4();
        $componentName = $request->post('name');
        $componentStock = $request->post('stock');
        $cost = $request->post('production_cost');
        $productionTime = $request->post('production_time');
        $default_qty = $request->post('default_qty');
        $requiredMaterial = $request->post('material');

        try {
            DB::table('raw_components')->insert([
                'id' => $id,
                'name' => $componentName,
                'stock' => $componentStock,
                'production_cost' => $cost,
                'production_time' => $productionTime,
                'default_qty' => $default_qty
            ]);

            $componentHasMaterials = [];

            for ($i = 0; $i < count($requiredMaterial); $i++) {
                $x = [
                    'id' => Uuid::uuid4(),
                    'raw_material_qty' => $requiredMaterial[$i]['raw_material_qty'],
                    'raw_component_id' => $id,
                    'raw_material_id' => $requiredMaterial[$i]['raw_material_id']
                ];

                array_push($componentHasMaterials, $x);
            }

            DB::table('raw_components_materials')->insert($componentHasMaterials);

            return ('sukses');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function insertMaterial(Request $request)
    {
        $materialName = $request->post('materialName');
        $materialStock = $request->post('materialStock');

        try {
            DB::table('raw_materials')->updateOrInsert([
                'id' => Uuid::uuid4(),
                'name' => $materialName,
                'stock' => $materialStock,
            ]);

            return ('success');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function getMaterial()
    {
        try {
            $material = DB::table('raw_materials')->get();
            return $material;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
