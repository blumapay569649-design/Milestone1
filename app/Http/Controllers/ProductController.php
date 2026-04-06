<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected function currentUser()
    {
        return Auth::user();
    }

    protected function requireAuth(): ?RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return null;
    }

    protected function accessibleWarehouses()
    {
        $user = $this->currentUser();
        return Warehouse::where('owner_id', $user->id)
            ->orWhereHas('members', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();
    }

    public function index(Request $request)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();
        $warehouses = $this->accessibleWarehouses();

        $query = Product::with(['warehouse', 'category', 'supplier', 'inventories'])
            ->whereIn('warehouse_id', $warehouses->pluck('id'));

        if ($request->filled('warehouse_id')) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(20);

        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('products.index', [
            'products' => $products,
            'warehouses' => $warehouses,
            'categories' => $categories,
            'suppliers' => $suppliers,
            'filters' => $request->only(['warehouse_id', 'category_id', 'search']),
        ]);
    }

    public function create()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $warehouses = $this->accessibleWarehouses();
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('products.create', [
            'warehouses' => $warehouses,
            'categories' => $categories,
            'suppliers' => $suppliers,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'sku' => 'required|string|max:255|unique:products',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
        ]);

        $warehouse = Warehouse::findOrFail($request->warehouse_id);
        $user = $this->currentUser();

        if (!$user->canAccessWarehouse($warehouse)) {
            abort(403);
        }

        $product = Product::create($request->only([
            'warehouse_id', 'category_id', 'supplier_id', 'name', 'description', 'sku', 'price'
        ]));

        $product->inventories()->create([
            'warehouse_id' => $request->warehouse_id,
            'quantity' => $request->quantity,
            'min_stock_level' => $request->min_stock_level,
        ]);

        return redirect()->route('products.show', $product);
    }

    public function show(Product $product)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();
        if (!$user instanceof User || !$user->canAccessWarehouse($product->warehouse)) {
            abort(403);
        }

        $product->load(['warehouse', 'category', 'supplier', 'inventories']);

        return view('products.show', [
            'product' => $product,
        ]);
    }

    public function edit(Product $product)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();

        if (!$user instanceof User) {
            abort(403);
        }

        $warehouses = $this->accessibleWarehouses();
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('products.edit', [
            'product' => $product,
            'warehouses' => $warehouses,
            'categories' => $categories,
            'suppliers' => $suppliers,
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();

        if (!$user instanceof User) {
            abort(403);
        }

        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'price' => 'required|numeric|min:0',
        ]);

        $warehouse = Warehouse::findOrFail($request->warehouse_id);

        if (!$user->canAccessWarehouse($warehouse)) {
            abort(403);
        }

        $product->update($request->only([
            'warehouse_id', 'category_id', 'supplier_id', 'name', 'description', 'sku', 'price'
        ]));

        return redirect()->route('products.show', $product);
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();

        if (!$user->canAccessWarehouse($product->warehouse)) {
            abort(403);
        }

        if (!$user instanceof User) {
            abort(403);
        }

        $product->delete();

        return redirect()->route('products.index');
    }
}
