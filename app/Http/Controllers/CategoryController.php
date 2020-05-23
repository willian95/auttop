<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Category;
use App\Diagnostic;

class CategoryController extends Controller
{
    
    function index(){

        return view('admin.category.index');

    }
    
    function store(CategoryStoreRequest $request){

        try{

            $category = new Category;
            $category->name = $request->name;
            $category->save();

            return response()->json(["success" => true, "msg" => "Categoría creada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }
        
    }

    function update(CategoryUpdateRequest $request){

        try{

            if(Category::where('name', $request->name)->where('id', '<>', $request->id)->count() == 0){
                
                $category = Category::find($request->id);
                $category->name = $request->name;
                $category->update();

                return response()->json(["success" => true, "msg" => "Categoría actualizada"]);
            
            }else{

                return response()->json(["success" => false, "msg" => "Este nombre ya existe"]);

            }

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }
        
    }

    function fetch($page = 1){

        try{

            $skip = ($page - 1) * 20;

            $categories = Category::skip($skip)->take(20)->get();
            $categoriesCount = Category::count();

            return response()->json(["success" => true, "categories" => $categories, "categoriesCount" => $categoriesCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function delete(Request $request){

        try{

            $category = Category::find($request->id);
            $category->delete();

            return response()->json(["success" => true, "msg" => "Categoría eliminada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function fetchAll(){
        
        try{

            $categories = Category::with('services')->get();
            return response()->json(["success" => true, "categories" => $categories]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function mechanicFetchAll($order_id){

        try{
            $arrayId = [];
            $services = Diagnostic::where('order_id', $order_id)->get();
            foreach($services as $service){

                array_push($arrayId, $service->service_id);

            }

            $categories = Category::with(['services' => function($q) use($arrayId){
                $q->whereNotIn('services.id', $arrayId);
            }])->get();

            return response()->json(["success" => true, "categories" => $categories]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

}
