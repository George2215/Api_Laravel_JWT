<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        //return Product::paginate(10);
        if (request()->wantsJson()) {
            $itemsPerPage = (int) request('itemsPerPage');
            $products = Product::filtered();
            
            return response()->json(
                [
                    "success" => true,
                    "data" => $products->paginate($itemsPerPage != 'undefined' ? $itemsPerPage : 10)
                ]
            );
        }
        abort(401);
    }

    public function show(int $id) {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function store() {
        $validator = Validator::make(request()->input(), [
            'name' => 'required|string|max:255|unique:products',
            'description' => 'required|string|max:600',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 422);
        }

        $product = Product::create([
            'name' => request('name'),
            'description' => request('description'),
            'price' => request('price'),
            'picture' => request('picture')
        ]);

        return response()->json(compact('product'),201);
    }

    public function update(int $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(["message" => "Producto no encontrado"], 404);
        }
        $validator = Validator::make(request()->input(), [
            'name' => 'required|string|max:255|unique:products,name,'.$id,
            'description' => 'required|string|max:600',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 422);
        }

        $product->fill([
            'name' => request('name'),
            'description' => request('description'),
            'price' => request('price'),
            'picture' => request('picture')
        ])->save();

        return response()->json(compact('product'),201);
    }

    public function destroy(int $id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(["message" => "Producto no encontrado"], 404);
        }
        $product->delete();
        return response()->json(["message" => "Producto eliminado"]);
    }
}
