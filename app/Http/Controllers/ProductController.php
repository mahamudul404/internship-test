<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features.*.feature_name' => 'required|string|max:255', // Validate features
            'features.*.feature_description' => 'nullable|string',
        ]);

        // Handle image upload
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/products', $imageName);

        // Create the product
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        // Create features
        foreach ($request->features as $featureData) {
            $product->features()->create($featureData);
        }

        return redirect()->route('create')->with('success', 'Product added successfully!');
    }
}
