<?php

namespace App\Http\Controllers;

use App\Models\Rw;
use App\Models\Kelurahan;
use Illuminate\Http\Request;

class RwController extends Controller
{
    
    //public function __construct()
    //{
    //    $this->middleware('auth');
    //} 

    public function index()
    {
        $rw = Rw::all();
        $kelurahan = Kelurahan::all();
        return view("rw.index", compact("rw",'kelurahan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rw = Rw::all();
        $kelurahan = Kelurahan::all();
        return view('rw.create', compact('rw','kelurahan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_rw' => 'required|max:4|unique:rws',
            'nama_rw' => 'required|unique:rws',
        ],
        [
            'kode_rw.required' => 'Kode Harus di Isi',
            'kode_rw.max' => 'Kode Maksimal 4 Nomer',
            'kode_rw.unique' => 'Kode Sudah Dipakai',
            'nama_rw.required' => 'Nama RW Harus di Isi',
            'nama_rw.unique' => 'Nama RW Sudah Dipakai',
        ]);

        $rw = new Rw();
        $rw->kode_rw = $request->kode_rw;
        $rw->nama_rw = $request->nama_rw;
        $rw->kelurahan_id = $request->kelurahan_id;
        $rw->save();
        return redirect()->route('rw.index')->with('sukses','Data Berhasil Di Tambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rw  $rw
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rw = Rw::findOrFail($id);
        $kelurahan = Kelurahan::all();
        return view('rw.show',compact('rw','kelurahan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rw  $rw
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rw = Rw::findOrFail($id);
        $kelurahan = Kelurahan::all();
        return view('rw.edit',compact('rw','kelurahan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rw  $rw
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rw = Rw::findOrFail($id);
        $rw->kode_rw = $request->kode_rw;
        $rw->nama_rw = $request->nama_rw;
        $rw->kelurahan_id = $request->kelurahan_id;
        $rw->save();
        return redirect()->route('rw.index')->with('sukses','Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rw  $rw
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $rw = Rw::findOrFail($id)->delete();
            \Session::flash('sukses','Data Berhasil Di Hapus');
        }catch(\Exception $e){
            \Session::flash('gagal',$e->getMessage());
        }
        return redirect()->route("rw.index");
        // $rw = rw::findOrFail($id)->delete();
        // return redirect()->route('rw.index')->with('sukses','Data Berhasil Di Hapus');
    }
}