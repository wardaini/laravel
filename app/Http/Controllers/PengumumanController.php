<?php


namespace App\Http\Controllers;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengumuman = Pengumuman::latest()->get();

        return view('pengumuman.index', compact('pengumuman'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengumuman.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
        ]);

        Pengumuman::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'tanggal' => today(),
        ]);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengumuman $pengumuman)
    {
        $user = Auth::user();
        $pengumuman->dibacaOleh()->syncWithoutDetaching([$user->id => ['dibaca_pada' => now()]]);

        return view('pengumuman.show', compact('pengumuman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengumuman $pengumuman)
{
    return view('pengumuman.edit', compact('pengumuman'));
}

public function update(Request $request, Pengumuman $pengumuman)
{
    $request->validate([
        'judul' => 'required',
        'isi' => 'required',
    ]);

    $pengumuman->update([
        'judul' => $request->judul,
        'isi' => $request->isi,
    ]);

    return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();
        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman dihapus.');
    
    }
}
