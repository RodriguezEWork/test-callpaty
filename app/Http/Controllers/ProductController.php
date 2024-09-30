<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $products = Product::with('category')->select('products.*');
            return DataTables::of($products)
                ->addColumn('action', function($row){
                    $actionBtn = '<button class="btn btn-info btn-sm btnEditar">Edit</button> ';
                    $actionBtn .= '<button class="btn btn-danger btn-sm btnEliminar">Delete</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'description' => 'required|string|min:10',
            'price' => 'required|numeric|min:1',
            'category_id' => 'required|exists:categories,id',
            'status' => 'boolean',
        ]);
        
        Product::create($request->all());
        return response()->json(['message' => 'Product created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json($product->toArray());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        $request->validate([
            'name' => 'string|min:3',
            'description' => 'string|min:10',
            'price' => 'numeric|min:1',
            'category_id' => 'exists:categories,id',
            'status' => 'boolean',
        ]);

        $product->update($request->all());
        return response()->json(['message' => 'Product updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
