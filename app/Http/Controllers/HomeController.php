<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegister;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    
    public function register(UserRegister $request)
    {
        try {
            $input = $request->validated();

            $input['role_id'] = 3;

            $store = User::create($input);
            if(!$store){
                return response()->json(['success' => false, 'message' => 'Account Not Created..']);
            }
            return response()->json(['success' => true, 'message' => 'Account created successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error register user']);
        }
    }


    public function index()
    {
        return view('home');
    }

    function fetchCategory()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    function fetchProducts()
    {
        $categoryId = request('category');
        $authorId = request('author');
        $priceFilter = request('price');

        $query = Product::with('category', 'subcategory', 'author');

        if ($categoryId) {
            $query->whereHas('category', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        if ($authorId) {
            $query->whereHas('author', function ($q) use ($authorId) {
                $q->where('user_id', $authorId);
            });
            // $query->where('author_id', $authorId);
        }
        if ($priceFilter === 'min') {
            $query->orderBy('price', 'asc');
        } elseif ($priceFilter === 'max') {
            $query->orderBy('price', 'desc');
        }

        $products = $query->get();
        return ProductResource::collection($products);
    }

    public function markAsFavorite(Request $request)
    {
        $userId = $request->input('userId');
        $bookId = $request->input('bookId');

        $user = User::find($userId);
        $book = Product::find($bookId);

        if ($user->favoriteBooks()->where('product_id', $bookId)->exists()) {
            return response()->json(['message' => 'Book is already marked as favorite.']);
        }

        $user->favoriteBooks()->attach($book);

        return response()->json(['message' => 'Book marked as favorite']);
    }

    public function removeFromFavorites(Request $request)
    {
        $userId = $request->input('userId');
        $bookId = $request->input('bookId');

        $user = User::find($userId);
        $book = Product::find($bookId);

        if (!$user->favoriteBooks()->where('product_id', $bookId)->exists()) {
            return response()->json(['message' => 'Book is not in favorites.']);
        }

        $user->favoriteBooks()->detach($book);

        return response()->json(['message' => 'Book removed from favorites']);
    }

    public function isInWishlist($bookId)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['isInWishlist' => false]);
        }

        $bookInWishlist = $user->favoriteBooks()->where('product_id', $bookId)->exists();

        return response()->json(['isInWishlist' => $bookInWishlist]);
    }

    function productById(Request $request){
        $product_id = request('product_id');

        $query = Product::with('category', 'subcategory');

        if ($product_id) {
                $query->where('id', $product_id);
        }


        $products = $query->get();
        return ProductResource::collection($products);
    }
}
