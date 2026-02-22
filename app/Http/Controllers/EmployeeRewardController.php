<?php

namespace App\Http\Controllers;

use App\Models\RewardProduct;
use App\Models\RewardExchange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeRewardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user->employee) {
            return redirect()->route('dashboard')->withErrors('Profil karyawan belum lengkap.');
        }

        $balance = $user->employee->reward_balance;
        $products = RewardProduct::where('is_active', true)->where('stock', '>', 0)->latest()->get();
        $exchanges = RewardExchange::where('employee_id', $user->id)->latest()->take(10)->get();

        return view('employee-rewards.index', compact('products', 'balance', 'exchanges'));
    }

    public function exchange(Request $request, RewardProduct $product)
    {
        $user = auth()->user();
        $employee = $user->employee;

        if (!$employee) {
            return back()->withErrors('Profil karyawan tidak ditemukan.');
        }

        if (!$product->is_active || $product->stock <= 0) {
            return back()->withErrors('Produk tidak tersedia.');
        }

        if ($employee->reward_balance < $product->points_cost) {
            return back()->withErrors('Saldo reward Anda tidak mencukupi.');
        }

        DB::transaction(function () use ($user, $employee, $product) {
            // Deduct balance
            $employee->decrement('reward_balance', $product->points_cost);

            // Create exchange request
            RewardExchange::create([
                'employee_id' => $user->id,
                'reward_product_id' => $product->id,
                'points_spent' => $product->points_cost,
                'status' => 'pending',
            ]);

            // Optional: Decrement stock. But wait, we might reserve the stock here and only deduct permanently upon approval. 
            // Or deduct stock now and if rejected, we restock it. Deducting now is safer so users don't overshoot inventory.
            $product->decrement('stock');
        });

        return back()->with('success', 'Permintaan penukaran reward berhasil dibuat. Menunggu persetujuan admin.');
    }
}
