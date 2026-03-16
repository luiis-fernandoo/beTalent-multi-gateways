<?php

namespace App\Http\Controllers;

use App\Http\Console\Constants\UserConstants;
use App\Http\Requests\ProductPostRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\User;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        return response()->json([
            'success' => true,
            'data' => Product::all()
        ]);
    }

    public function store(ProductPostRequest $request){
        $manager = User::find($request->header('x-user-id'));

        if(!$manager->role_id == UserConstants::ADMIN || !$manager->role_id == UserConstants::MANAGER) {
            return response()->json([
                'success' => false,
                'message' => 'Você não tem permissão para isso!'
            ], 401);
        }

        try {
            $product = (new ProductRepository())->createProduct($request->validated());
        }catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    public function update(ProductUpdateRequest $request, $productId){
        $manager = User::find($request->header('x-user-id'));

        if(!$manager->role_id == UserConstants::ADMIN || !$manager->role_id == UserConstants::MANAGER) {
            return response()->json([
                'success' => false,
                'message' => 'Você não tem permissão para isso!'
            ], 401);
        }

        try {
            $product = (new ProductRepository())->updateProduct($request->validated(), $productId);
        }catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    public function destroy(Request $request, $productId){
        $manager = User::find($request->header('x-user-id'));

        if(!$manager->role_id == UserConstants::ADMIN || !$manager->role_id == UserConstants::MANAGER) {
            return response()->json([
                'success' => false,
                'message' => 'Você não tem permissão para isso!'
            ], 401);
        }

        try {
            (new ProductRepository())->destroyProduct($productId);
        }catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'produto deletado'
        ], 201);
    }
}
