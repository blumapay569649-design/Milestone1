<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\WarehouseItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
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

    public function index(Warehouse $warehouse)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();
        if (!$user->canAccessWarehouse($warehouse)) {
            abort(403);
        }

        $items = $warehouse->items;

        return view('items.index', [
            'warehouse' => $warehouse,
            'items' => $items,
        ]);
    }

    public function create(Warehouse $warehouse)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();
        if (!$user->canAccessWarehouse($warehouse)) {
            abort(403);
        }

        return view('items.create', [
            'warehouse' => $warehouse,
        ]);
    }

    public function store(Request $request, Warehouse $warehouse): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();
        if (!$user->canAccessWarehouse($warehouse)) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:51200', // 50MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('warehouse_items', 'public');
        }

        WarehouseItem::create([
            'warehouse_id' => $warehouse->id,
            'name' => $request->name,
            'qty' => $request->qty,
            'price' => $request->price,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('warehouses.show', $warehouse);
    }

    public function show(Warehouse $warehouse, WarehouseItem $item)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();
        if (!$user->canAccessWarehouse($warehouse) || $item->warehouse_id !== $warehouse->id) {
            abort(403);
        }

        return view('items.show', [
            'warehouse' => $warehouse,
            'item' => $item,
        ]);
    }

    public function edit(Warehouse $warehouse, WarehouseItem $item)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();
        if (!$user->canAccessWarehouse($warehouse) || $item->warehouse_id !== $warehouse->id) {
            abort(403);
        }

        return view('items.edit', [
            'warehouse' => $warehouse,
            'item' => $item,
        ]);
    }

    public function update(Request $request, Warehouse $warehouse, WarehouseItem $item): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();
        if (!$user->canAccessWarehouse($warehouse) || $item->warehouse_id !== $warehouse->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:51200',
        ]);

        $imagePath = $item->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('warehouse_items', 'public');
        }

        $item->update([
            'name' => $request->name,
            'qty' => $request->qty,
            'price' => $request->price,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('warehouses.show', $warehouse);
    }

    public function destroy(Warehouse $warehouse, WarehouseItem $item): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $user = $this->currentUser();
        if (!$user->canAccessWarehouse($warehouse) || $item->warehouse_id !== $warehouse->id) {
            abort(403);
        }

        $item->delete();

        return redirect()->route('warehouses.show', $warehouse);
    }
}
