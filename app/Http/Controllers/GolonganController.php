<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use Illuminate\Http\Request;

class GolonganController extends Controller
{
    public function index()
    {
        $golongan = Golongan::all();
        return view('golongan.index', compact('golongan'));
    }

    public function create()
    {
        return view('golongan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_golongan' => 'required|string|max:50|unique:golongan,nama_golongan',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan_keluarga' => 'required|numeric|min:0',
            'uang_makan_bulanan' => 'required|numeric|min:0',
            'uang_transport_bulanan' => 'required|numeric|min:0',
            'thr_nominal' => 'nullable|numeric|min:0',
            'bpjs_per_tanggungan' => 'required|numeric|min:0',
            'bonus_tahunan' => 'nullable|numeric|min:0',
        ]);

        $data = $request->only([
            'nama_golongan',
            'gaji_pokok',
            'tunjangan_keluarga',
            'uang_makan_bulanan',
            'uang_transport_bulanan',
            'thr_nominal',
            'bpjs_per_tanggungan',
            'bonus_tahunan',
        ]);

        // PERBAIKAN: Jika THR atau Bonus dikosongkan, nilainya akan menjadi 0.
        if (empty($data['thr_nominal'])) {
            $data['thr_nominal'] = 0;
        }
        if (empty($data['bonus_tahunan'])) {
            $data['bonus_tahunan'] = 0;
        }

        Golongan::create($data);

        return redirect()->route('golongan.index')->with('success', 'Data golongan berhasil ditambahkan!');
    }

    public function edit(Golongan $golongan)
    {
        return view('golongan.edit', compact('golongan'));
    }

    public function update(Request $request, Golongan $golongan)
    {
        $request->validate([
            'nama_golongan' => 'required|string|max:50',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan_keluarga' => 'required|numeric|min:0',
            'uang_makan_bulanan' => 'required|numeric|min:0',
            'uang_transport_bulanan' => 'required|numeric|min:0',
            'thr_nominal' => 'nullable|numeric|min:0',
            'bpjs_per_tanggungan' => 'required|numeric|min:0',
            'bonus_tahunan' => 'nullable|numeric|min:0',
        ]);

        $data = $request->only([
            'nama_golongan',
            'gaji_pokok',
            'tunjangan_keluarga',
            'uang_makan_bulanan',
            'uang_transport_bulanan',
            'thr_nominal',
            'bpjs_per_tanggungan',
            'bonus_tahunan',
        ]);

        // PERBAIKAN: Jika THR atau Bonus dikosongkan, nilainya akan menjadi 0.
        if (empty($data['thr_nominal'])) {
            $data['thr_nominal'] = 0;
        }
        if (empty($data['bonus_tahunan'])) {
            $data['bonus_tahunan'] = 0;
        }

        $golongan->update($data);

        return redirect()->route('golongan.index')->with('success', 'Data golongan berhasil diperbarui!');
    }

    public function destroy(Golongan $golongan)
    {
        $golongan->delete();
        return redirect()->route('golongan.index')->with('success', 'Data golongan berhasil dihapus!');
    }
}
