<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Inertia\Inertia;

use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->search, function ($q) use ($request) {
                $q->where('product_name', 'like', '%' . $request->search . '%');
            })
            ->when($request->category, function ($q) use ($request) {
                $q->where('product_category', $request->category);
            })
            ->when($request->stock === 'in', function ($q) {
                $q->where('product_stock', '>', 0);
            })
            ->when($request->stock === 'out', function ($q) {
                $q->where('product_stock', '=', 0);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // ⭐ keeps filters during pagination

        return Inertia::render('Admin/Products/Index', [
            'products' => $products,
            'filters' => $request->only(['search', 'category', 'stock']),
        ]);
    }


    public function create()
    {
        return Inertia::render('Admin/Products/Create');
    }

    // STORE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_category' => 'required|string|max:255',
            'product_stock' => 'required|integer|min:0',
            'product_description' => 'nullable|string',
            'product_image' => 'nullable|string',
        ]);

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        return Inertia::render('Admin/Products/Edit', [
            'product' => $product,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_category' => 'required|string|max:255',
            'product_stock' => 'required|integer|min:0',
            'product_description' => 'nullable|string',
            'product_image' => 'nullable|string',
        ]);

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->back()
            ->with('success', 'Product deleted successfully');
    }
}
