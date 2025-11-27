<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KurirController extends Controller
{
    public function index()
    {
        $kurirs = User::where('role', 'kurir')
            ->withCount('transaksiKurir')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.kurir.index', compact('kurirs'));
    }

    public function create()
    {
        return view('admin.kurir.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'kurir',
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.kurir.index')
            ->with('success', 'Kurir berhasil ditambahkan.');
    }

    public function show(User $kurir)
    {
        if ($kurir->role !== 'kurir') {
            abort(404);
        }
        
        $kurir->load(['transaksiKurir' => function($query) {
            $query->with(['user', 'detailTransaksis.paket'])
                  ->orderBy('created_at', 'desc')
                  ->limit(10);
        }]);
        
        return view('admin.kurir.show', compact('kurir'));
    }

    public function edit(User $kurir)
    {
        if ($kurir->role !== 'kurir') {
            abort(404);
        }
        
        return view('admin.kurir.edit', compact('kurir'));
    }

    public function update(Request $request, User $kurir)
    {
        if ($kurir->role !== 'kurir') {
            abort(404);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $kurir->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];
        
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $kurir->update($data);

        return redirect()->route('admin.kurir.index')
            ->with('success', 'Data kurir berhasil diperbarui.');
    }

    public function destroy(User $kurir)
    {
        if ($kurir->role !== 'kurir') {
            abort(404);
        }
        
        // Cek apakah kurir masih memiliki transaksi aktif
        $activeTransactions = $kurir->transaksiKurir()
            ->whereNotIn('status_transaksi', ['selesai'])
            ->count();
            
        if ($activeTransactions > 0) {
            return redirect()->route('admin.kurir.index')
                ->with('error', 'Tidak dapat menghapus kurir yang masih memiliki transaksi aktif.');
        }
        
        $kurir->delete();
        
        return redirect()->route('admin.kurir.index')
            ->with('success', 'Kurir berhasil dihapus.');
    }
}
