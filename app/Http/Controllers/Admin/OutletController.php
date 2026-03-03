<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    public function index()
    {
        $outlets = Outlet::latest()->paginate(10);
        return view('admin.outlet.index', compact('outlets'));
    }

    public function create()
    {
        return view('admin.outlet.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_outlet' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'nullable|email',
            'jam_buka' => 'required',
            'jam_tutup' => 'required',
            'maps_url' => 'nullable|url',
        ]);

        Outlet::create($request->all());

        return redirect()->route('admin.outlet.index')
            ->with('success', 'Outlet berhasil ditambahkan.');
    }

    public function edit(Outlet $outlet)
    {
        return view('admin.outlet.edit', compact('outlet'));
    }

    public function update(Request $request, Outlet $outlet)
    {
        $request->validate([
            'nama_outlet' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'nullable|email',
            'jam_buka' => 'required',
            'jam_tutup' => 'required',
            'maps_url' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        $outlet->update($request->all());

        return redirect()->route('admin.outlet.index')
            ->with('success', 'Outlet berhasil diperbarui.');
    }

    public function destroy(Outlet $outlet)
    {
        $outlet->delete();
        return redirect()->route('admin.outlet.index')
            ->with('success', 'Outlet berhasil dihapus.');
    }
}