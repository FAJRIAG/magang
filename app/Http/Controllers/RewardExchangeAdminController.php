<?php

namespace App\Http\Controllers;

use App\Models\RewardExchange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RewardExchangeAdminController extends Controller
{
    public function __construct()
    {
        if (auth()->check() && auth()->user()->role === 'employee') {
            abort(403, 'Akses ditolak.');
        }
    }

    public function index()
    {

        $exchanges = RewardExchange::with(['employee', 'rewardProduct'])->latest()->paginate(15);
        return view('reward-exchanges.admin.index', compact('exchanges'));
    }

    public function approve(RewardExchange $exchange)
    {

        if ($exchange->status !== 'pending') {
            return back()->withErrors('Penukaran ini sudah diproses sebelumnya.');
        }

        $exchange->update(['status' => 'approved']);

        return back()->with('success', 'Penukaran reward berhasil disetujui.');
    }

    public function reject(Request $request, RewardExchange $exchange)
    {

        if ($exchange->status !== 'pending') {
            return back()->withErrors('Penukaran ini sudah diproses sebelumnya.');
        }

        $request->validate(['reason' => 'required|string|max:255']);

        DB::transaction(function () use ($exchange, $request) {
            $exchange->update([
                'status' => 'rejected',
                'reason' => $request->reason
            ]);

            // Refund points to the employee
            $user = $exchange->employee;
            if ($user && $user->employee) {
                $user->employee->increment('reward_balance', $exchange->points_spent);
            }

            // Restore product stock
            if ($exchange->rewardProduct) {
                $exchange->rewardProduct->increment('stock');
            }
        });

        return back()->with('success', 'Penukaran reward ditolak. Poin telah dikembalikan.');
    }
}
