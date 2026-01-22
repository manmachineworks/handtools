<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    /**
     * Admin: List brands with search + pagination.
     */
    public function index(Request $request)
    {
        $search = $request->input('q');

        $brands = Brand::when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('slug', 'like', '%' . $search . '%');
        })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.brands.index', compact('brands', 'search'));
    }

    /**
     * Admin: Show create form.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Admin: Store new brand.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:brands,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeImage($request->file('image'));
        }

        Brand::create($data);

        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
    }

    /**
     * Admin: Show edit form.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Admin: Update brand.
     */
    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('brands', 'slug')->ignore($brand->id),
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            if (!empty($brand->image) && file_exists(public_path($brand->image))) {
                @unlink(public_path($brand->image));
            }
            $data['image'] = $this->storeImage($request->file('image'));
        }

        $brand->update($data);

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    /**
     * Admin: Delete brand (null brand_id on products).
     */
    public function destroy(Brand $brand)
    {
        Product::where('brand_id', $brand->id)->update(['brand_id' => null]);

        if (!empty($brand->image) && file_exists(public_path($brand->image))) {
            @unlink(public_path($brand->image));
        }

        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully.');
    }

    /**
     * Front: brand-wise product listing.
     */
    public function show($slug, Request $request)
    {
        $brand = Brand::active()->where('slug', $slug)->firstOrFail();
        $query = Product::with(['images', 'subcategory.category', 'category'])
            ->where('brand_id', $brand->id);

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where('product_name', 'like', '%' . $search . '%');
        }

        $products = $query->paginate(12)->withQueryString();

        $categoriesTree = Category::select('id', 'name', 'slug')
            ->with(['subcategories:id,name,slug,category_id'])
            ->orderBy('name')
            ->get();

        $activeCategorySlug = null;
        $activeSubcategorySlug = null;

        $breadcrumb = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => $brand->name, 'url' => ''],
        ];

        $meta = (object) [
            'title' => $brand->name . ' Products',
            'keyword' => $brand->name,
            'description' => 'Browse products from ' . $brand->name,
        ];

        if ($request->ajax()) {
            $html = view('products.partials.product-grid', [
                'products' => $products,
                'category' => null,
                'emptyMessage' => 'No products found for this brand.',
            ])->render();

            $pagination = $products->hasPages() ? $products->links()->toHtml() : '';

            return response()->json([
                'html' => $html,
                'pagination' => $pagination,
                'hasProducts' => $products->count() > 0,
            ]);
        }

        return view('brands.show', compact(
            'brand',
            'products',
            'breadcrumb',
            'meta',
            'categoriesTree',
            'activeCategorySlug',
            'activeSubcategorySlug'
        ));
    }

    private function storeImage($file): string
    {
        $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/img/brands'), $fileName);

        return 'assets/img/brands/' . $fileName;
    }
}
