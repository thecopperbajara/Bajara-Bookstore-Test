<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductAdd;
use App\Http\Requests\ProductUpdate;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::with('category', 'subcategory')->orderBy('id', 'desc');

        $products = $query->paginate(10);

        // $products = Product::with('category', 'subcategory')->orderBy('id', 'desc')->paginate(10);
        return ProductResource::collection($products);
    }

    public function store(ProductAdd $request)
    {
        try {
            $input = $request->validated();

            if ($image = $request->file('image')) {
                $ext = $image->extension();
                $file = time() . '.' . $ext;
                $image->storeAs('public/product', $file);
                $input['image'] = $file;
            }

            $create = Product::create($input);
            if (!$create) {
                return response()->json(['success' => false, 'message' => 'Product Not Created..'], 422);
            }
            return response()->json(['success' => true, 'message' => 'Product Created..'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something went wrong..'], 500);
        }
    }


    public function show(Product $product)
    {
        return response()->json($product);
    }

    public function update(ProductUpdate $request, Product $product)
    {
        try {
            $input = $request->validated();

            if ($image = $request->file('image')) {
                $ext = $image->extension();
                $file = time() . '.' . $ext;
                $image->storeAs('public/product', $file);
                $input['image'] = $file;
            }

            $update = $product->update($input);
            if (!$update) {
                return response()->json(['success' => false, 'message' => 'Product Not Updated..'], 422);
            }
            return response()->json(['success' => true, 'message' => 'Product Update successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error Update User..'], 500);
        }
    }

    public function destroy(Product $product)
    {
        // if (!empty($product->image)) {
        //     Storage::disk('public/product/')->delete($product->image);
        // }

        $product->delete();
        return response()->json(['success' => true, 'message' => 'Product Deleted successfully'], 200);
    }
}
