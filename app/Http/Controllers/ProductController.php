<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProduct;
use App\Models\Carts;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function addProductsView()
    {
        return view('addproducts');
    }
    public function viewProducts()
    {
        return view('viewproducts');
    }
    public function getAllProducts()
    {
        $data['products'] = Product::all();
        return view('allproducts', $data);
    }
    public function addProducts(AddProduct $request)
    {
        DB::beginTransaction();
        try {
            $addProduct = new Product();
            $addProduct->name = $request->input('name');
            $addProduct->price = $request->input('price');
            $addProduct->save();

            $productId = $addProduct->id;

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $addProductImage = new ProductImages();
                    $addProductImage->product_id = $productId;
                    $imagePath = $image->store('public/product_images');

                    $imagePath = str_replace('public/', '', $imagePath);

                    $addProductImage->image_url = $imagePath;

                    $addProductImage->save();
                }
            }

            DB::commit();

            return response()->json(['type' => 'success', 'code' => 200, 'status' => true, 'message' => 'Product added successfully.', 'toast' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error product adding: ' . $e->getMessage());
            return response()->json(['type' => 'error', 'code' => 500, 'status' => false, 'message' => 'Error while processing', 'toast' => true]);
        }
    }
    public function getProducts(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);
            $offset = $request->input('offset', 0);
            if ($request->has('product_id')) {
                $product = Product::where('id', $request->product_id)->first();

                if ($product) {
                    $images = ProductImages::where('product_id', $product->id)->get();
                    $product->images = $images;

                    return response()->json(['type' => 'success', 'code' => 200, 'status' => true, 'message' => 'Product retrieved successfully.', 'data' => $product, 'toast' => true]);
                } else {
                    return response()->json(['type' => 'error', 'code' => 200, 'status' => false, 'message' => 'Product not found.', 'toast' => true]);
                }
            }
            $products = Product::skip($offset)->take($limit)->get();

            foreach ($products as $product) {
                $images = ProductImages::where('product_id', $product->id)->get();
                $product->images = $images;
            }

            return response()->json(['type' => 'success', 'code' => 200, 'status' => true, 'message' => 'Products retrieved successfully.', 'data' => $products, 'toast' => true]);
        } catch (\Exception $e) {
            Log::error('Error retrieving products: ' . $e->getMessage());
            return response()->json(['type' => 'error', 'code' => 500, 'status' => false, 'message' => 'Error while processing', 'toast' => true]);
        }
    }
    public function addToCart(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = User::find($request->user_id);

            if (!$user) {
                return response()->json(['type' => 'error', 'code' => 200, 'status' => false, 'message' => 'User not found', 'toast' => true]);
            }

            $existingCartItem = Carts::where('product_id', $request->product_id)
                ->where('user_id', $request->user_id)
                ->first();

            if ($existingCartItem) {
                $existingCartItem->quantity += $request->input('quantity');
                $existingCartItem->price += $request->input('price');
                $existingCartItem->save();
            } else {
                $cartItem = new Carts();
                $cartItem->product_id = $request->input('product_id');
                $cartItem->quantity = $request->input('quantity');
                $cartItem->price = $request->input('quantity') * $request->input('price');
                $cartItem->user_id = $request->user_id;
                $cartItem->save();
            }

            DB::commit();

            return response()->json(['type' => 'success', 'code' => 200, 'status' => true, 'message' => 'Product added to cart.', 'toast' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error adding product to cart: ' . $e->getMessage());
            return response()->json(['type' => 'error', 'code' => 200, 'status' => false, 'message' => 'Error while processing', 'toast' => true]);
        }
    }
    public function getCart(Request $request)
    {
        try {
            $user_id = 1;
            $limit = $request->input('limit', 10);
            $offset = $request->input('offset', 0);

            $cartItems = Carts::where('user_id', $user_id)
                ->limit($limit)
                ->offset($offset)
                ->get();
            $cartItemCount = $cartItems->count();

            $products = [];
            foreach ($cartItems as $cartItem) {
                $product = Product::find($cartItem->product_id);
                if ($product) {
                    $images = ProductImages::where('product_id', $product->id)->get();
                    $product->images = $images;
                    $products[] = $product;
                }
            }

            return response()->json(['type' => 'success', 'code' => 200, 'status' => true, 'message' => 'Cart Products retrieved successfully.', 'data' => ['products' => $products, 'cart_item_count' => $cartItemCount], 'toast' => true]);
        } catch (\Exception $e) {
            Log::error('Error retrieving cart: ' . $e->getMessage());
            return response()->json(['type' => 'error', 'code' => 200, 'status' => false, 'message' => 'Error while processing', 'toast' => true]);
        }
    }
    public function cartData()
    {
        $user_id = 1;

        $cartData = Carts::where('user_id', $user_id)->get();

        $productData = [];
        foreach ($cartData as $cartItem) {
            $product = Product::find($cartItem->product_id);
            if ($product) {
                $productData[$cartItem->product_id] = $product;
            }
        }

        $productImages = [];

        foreach ($cartData as $cartItem) {
            $images = ProductImages::where('product_id', $cartItem->product_id)->get();

            $productImages[$cartItem->product_id] = $images;
        }
        $totalAmount = 0;
        foreach ($cartData as $cartItem) {
            $product = Product::find($cartItem->product_id);
            if ($product) {
                $totalAmount += $product->price * $cartItem->quantity;
            }
        }

        $data = [
            'cartData' => $cartData,
            'productData' => $productData,
            'productImages' => $productImages,
            'totalAmount' => $totalAmount,
        ];

        return view('cartdata', $data);
    }
}
