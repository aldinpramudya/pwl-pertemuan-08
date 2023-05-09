<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\Kelas;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $search = $request->search;
        if(strlen($search)){
            $mahasiswas = Mahasiswa::where('Nama', 'LIKE', "%$search%") -> paginate(5);
        }
        else{
            $mahasiswas = Mahasiswa::paginate(5);
        }
        return view('mahasiswas.index', ['mahasiswas'=>$mahasiswas]);
    }   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswas.create',['Kelas'=>$kelas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Email' => 'required',
            'TanggalLahir' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
        ]);

        if($request->file('featured_image')){
            $path = $request->file('featured_image')->store('images', 'public');
        }

        //Fungsi Eloquent untuk menambah data
        $mahasiswas = new Mahasiswa;
        $mahasiswas->Nim=$request->get('Nim');
        $mahasiswas->Nama=$request->get('Nama');
        $mahasiswas->featured_image=$path;
        $mahasiswas->Email=$request->get('Email');
        $mahasiswas->TanggalLahir=$request->get('TanggalLahir');
        $mahasiswas->Jurusan=$request->get('Jurusan');
        $mahasiswas->No_Handphone=$request->get('No_Handphone');

        //Fungsi Eloquent untuk menambah data belongsto
        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        $mahasiswas->kelas()->associate($kelas);
        $mahasiswas->save();

        return redirect()->route('mahasiswas.index')->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($Nim)
    {
        $Mahasiswa = Mahasiswa::find($Nim);
        return view('mahasiswas.detail', compact('Mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($Nim)
    {
        $Mahasiswa = Mahasiswa::find($Nim);
        $kelas = Kelas::all();
        return view('mahasiswas.edit', compact('Mahasiswa'), ['Kelas' => $kelas]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $Nim)
    {
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Email' => 'required',
            'TanggalLahir' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
        ]);

        // Mahasiswa::find($Nim)->update($request->all());

        $mahasiswas = Mahasiswa::with('Kelas')->where('Nim', $Nim)->first();
        
        if($mahasiswas->featured_image && file_exists(storage_path('app/public/'.$mahasiswas->featured_image))){
            Storage::delete('public/'.$mahasiswas->featured_image);
        }
        $path = $request->file('featured_image')->store('images', 'public');
        $mahasiswas->featured_image=$path;

        $mahasiswas->Nim=$request->get('Nim');
        $mahasiswas->Nama=$request->get('Nama');
        $mahasiswas->Email=$request->get('Email');
        $mahasiswas->TanggalLahir=$request->get('TanggalLahir');
        $mahasiswas->Jurusan=$request->get('Jurusan');
        $mahasiswas->No_Handphone=$request->get('No_Handphone');

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        $mahasiswas->kelas()->associate($kelas);
        $mahasiswas->save();

        return redirect()->route('mahasiswas.index')->with('success', 'Mahasiswa Berhasil Diupdate');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($Nim)
    {
        $mahasiswas = Mahasiswa::find($Nim);
        if($mahasiswas->featured_image && file_exists(storage_path('app/public/'.$mahasiswas->featured_image))){
            Storage::delete('public/'.$mahasiswas->featured_image);
        }
        $mahasiswas->matakuliah()->detach();
        $mahasiswas->delete();
        return redirect()->route('mahasiswas.index')
            -> with('success', 'Mahasiswa Berhasil Dihapus');

    }
}
