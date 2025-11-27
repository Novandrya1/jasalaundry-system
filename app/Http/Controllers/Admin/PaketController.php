<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.paket.index', compact('pakets'));
    }

    public function create()
    {
        return view('admin.paket.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga_per_kg' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'satuan' => 'required|in:kg,pcs',
        ]);

        Paket::create($request->all());

        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function show(Paket $paket)
    {
        return view('admin.paket.show', compact('paket'));
    }

    public function edit(Paket $paket)
    {
        return view('admin.paket.edit', compact('paket'));
    }

    public function update(Request $request, Paket $paket)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga_per_kg' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'satuan' => 'required|in:kg,pcs',
            'is_active' => 'boolean',
        ]);

        $paket->update($request->all());

        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(Paket $paket)
    {
        $paket->delete();
        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil dihapus.');
    }
}
