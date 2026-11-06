<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //Product List
    public function index(Request $request)
    {
        $title = "Product List";
        $search = true;
        $nav = [
            [
                'url' => route('admin.login.view'),
                'name' => 'Dashboard'
            ],
            [
                'name' => $title
            ]
        ];


        $products = Product::query()
            ->paginate($request->integer('per_page', 20));
        return view('admin.product.index', compact('title', 'search', 'nav', 'products'));
    }

    public function add()
    {
        $title = "Add Product";
        $nav = [
            [
                'url'  => route('admin.products.index'),
                'name' => 'Product Listing'
            ],
            [
                'name' => $title
            ]
        ];
        $collapsed = false;

        $categories = Category::active()->get();
        $notes = [];
        return view('admin.product.form', compact('title', 'nav', 'collapsed', 'categories', 'notes'));
    }

    public function addToMedia(Request $request, ?Product $product = null)
    {
        $request->validate([
            'media' => 'required|file|mimes:jpg,jpeg,png,webp,mp4|max:10240',
        ]);

        if ($product) {
            abort_if($product->vendor_id !== auth('web')->id(), 403);
            // abort_if(!in_array($product->status, ['draft', 'rejected']), 422, 'Product is not editable.');
        } else {
            $product = Product::create([
                'vendor_id' => auth('web')->id(),
                'name'      => 'Untitled product',
                'slug'      => (string) Str::uuid(),
                'status'    => 'draft',
            ]);
        }

        $path = $request->file('media')->store("products/{$product->slug}", 'public');

        $media = $product->media()->create([
            'path' => $path,
            'type' => $request->file('media')->getMimeType(),
        ]);

        return response()->json([
            'product_id' => $product->id,
            'media'      => $media,
        ], 201);
    }
}
