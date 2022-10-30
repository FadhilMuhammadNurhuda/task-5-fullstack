<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        // dd($category);

        return response()->json([
            'category' => CategoryResource::collection($category),
            'message' => 'success'
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // dd(auth('api')->user()->id);

        $user_id = auth('api')->user()->id;

        $validatr = Validator::make($data, [
            'name' => 'required|max:255'
        ]);

        if ($validatr->fails()) {
            return response()->json([
                'eror' => $validatr->errors(), 'validation eror'
            ]);
        }


        $data['user_id'] =  $user_id;
        $category = Category::create($data);
        return response()->json([
            'data' => new CategoryResource($category),
            'success' => 'succes for store category'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $validate = Validator::make($data, [
            'name' => 'required|max:255'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'eror' => $validate->errors(), 'validation eror'
            ]);
        }

        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();

        return response()->json([
            'data' => new CategoryResource($category),
            'success' => 'success for update category'
        ], 200);
    }
}
