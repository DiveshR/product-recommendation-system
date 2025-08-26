<?php

namespace App\Services;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Cache;

class HybridRecommendationService
{
    public function recommend(User $user, $limit = 10)
    {
        // Cache key
        $cacheKey = "hybrid_recommendations_{$user->id}";

        return Cache::remember($cacheKey, 3600, function () use ($user, $limit) {

            // -------------------------
            // 1️⃣ Collaborative Filtering
            // -------------------------
            $purchased = Order::where('user_id', $user->id)->pluck('product_id')->toArray();

            $similarUserIds = Order::whereIn('product_id', $purchased)
                ->where('user_id', '!=', $user->id)
                ->pluck('user_id')
                ->unique()
                ->toArray();

            $collabProductIds = [];
            if (!empty($similarUserIds)) {
                $collabProductIds = Order::whereIn('user_id', $similarUserIds)
                    ->whereNotIn('product_id', $purchased)
                    ->pluck('product_id')
                    ->unique()
                    ->toArray();
            }

            // -------------------------
            // 2️⃣ Content-Based Filtering
            // -------------------------
            // Products similar by title keywords
            $similarProducts = [];
            if (!empty($purchased)) {
                $firstPurchased = Product::find($purchased[0]);
                if ($firstPurchased) {
                    $keywords = explode(' ', $firstPurchased->title);
                    $similarProducts = Product::where(function ($q) use ($keywords) {
                        foreach ($keywords as $word) {
                            $q->orWhere('title', 'like', "%$word%");
                        }
                    })
                        ->whereNotIn('id', $purchased)
                        ->pluck('id')
                        ->toArray();
                }
            }

            // -------------------------
            // 3️⃣ Combine both
            // -------------------------
            $allRecommendedIds = array_unique(array_merge($collabProductIds, $similarProducts));

            if (empty($allRecommendedIds)) {
                // fallback: random products
                return Product::whereNotIn('id', $purchased)->inRandomOrder()->limit($limit)->get();
            }

            return Product::whereIn('id', $allRecommendedIds)
                ->inRandomOrder()
                ->limit($limit)
                ->get();
        });
    }
}
