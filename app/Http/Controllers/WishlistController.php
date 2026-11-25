<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthorized'], 401);
        }

        $user = Auth::user();
        $product = Product::findOrFail($request->product_id);

        if ($user->wishlist()->where('product_id', $product->id)->exists()) {
            $user->wishlist()->detach($product->id);

            if ($product->likes_count > 0) {
                $product->decrement('likes_count');
            }

            return response()->json([
                'status' => 'removed',
                'count' => $product->likes_count
            ]);
        } else {
            $user->wishlist()->attach($product->id);

            $product->increment('likes_count');

            return response()->json([
                'status' => 'added',
                'count' => $product->likes_count
            ]);
        }
    }
}
