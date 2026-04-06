<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    protected function requireAuth(): ?RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return null;
    }

    public function index()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $suppliers = Supplier::withCount('products')->get();

        return view('suppliers.index', [
            'suppliers' => $suppliers,
        ]);
    }

    public function create()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        return view('suppliers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:suppliers',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:1000',
        ]);

        Supplier::create($request->only(['name', 'email', 'phone', 'address']));

        return redirect()->route('suppliers.index');
    }

    public function edit(Supplier $supplier)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        return view('suppliers.edit', [
            'supplier' => $supplier,
        ]);
    }

    public function update(Request $request, Supplier $supplier): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:suppliers,name,' . $supplier->id,
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:1000',
        ]);

        $supplier->update($request->only(['name', 'email', 'phone', 'address']));

        return redirect()->route('suppliers.index');
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $supplier->delete();

        return redirect()->route('suppliers.index');
    }
}
