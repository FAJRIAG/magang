<?php

namespace App\Http\Controllers;

use App\Models\RewardProduct;
use Illuminate\Http\Request;

class RewardProductController extends Controller
{
    public function __construct()
    {
        if (auth()->check() && auth()->user()->role === 'employee') {
            abort(403, 'Akses ditolak.');
        }
    }

    public function index()
    {

        $products = RewardProduct::latest()->paginate(10);
        return view('reward-products.index', compact('products'));
    }

    public function create()
    {

        return view('reward-products.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:food,drink',
            'points_cost' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        RewardProduct::create($validated);

        return redirect()->route('reward-products.index')->with('success', 'Produk reward berhasil ditambahkan.');
    }

    public function edit(RewardProduct $rewardProduct)
    {

        return view('reward-products.edit', compact('rewardProduct'));
    }

    public function update(Request $request, RewardProduct $rewardProduct)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:food,drink',
            'points_cost' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $rewardProduct->update($validated);

        return redirect()->route('reward-products.index')->with('success', 'Produk reward berhasil diperbarui.');
    }

    public function destroy(RewardProduct $rewardProduct)
    {

        $rewardProduct->delete();

        return redirect()->route('reward-products.index')->with('success', 'Produk reward berhasil dihapus.');
    }
}
