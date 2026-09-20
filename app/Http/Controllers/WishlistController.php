<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggle(Request $request)
    {
        // Ulanyjy girmedik bolsa
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthorized'], 401);
        }

        $user = Auth::user();
        $product = Product::findOrFail($request->product_id);

        // Toggle (Bar bolsa aýyr, ýok bolsa goş)
        if ($user->wishlist()->where('product_id', $product->id)->exists()) {
            $user->wishlist()->detach($product->id);

            // Sany 1 azalt (ýöne 0-dan aşak düşmesin)
            if ($product->likes_count > 0) {
                $product->decrement('likes_count');
            }

            return response()->json([
                'status' => 'removed',
                'count' => $product->likes_count
            ]);
        } else {
            $user->wishlist()->attach($product->id);

            // Sany 1 artdyr
            $product->increment('likes_count');

            return response()->json([
                'status' => 'added',
                'count' => $product->likes_count
            ]);
        }
    }
}
