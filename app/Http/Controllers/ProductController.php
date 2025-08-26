<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HybridRecommendationService;

class ProductController extends Controller
{
    protected $recommend;

    public function __construct(HybridRecommendationService $recommend)
    {
        $this->recommend = $recommend;
    }

    public function recommendations(Request $request)
    {
        $user = $request->user(); // authenticated user

        $products = $this->recommend->recommend($user, 10);

        return response()->json($products);
    }
}
