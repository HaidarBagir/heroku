<?php

namespace App\Http\Livewire;

use App\Models\Rw;
use App\Models\kelurahan;
use App\Models\kecamatan;
use App\Models\kota;
use App\Models\Provinsi;
use App\Models\kasuses;
use Livewire\Component;

class Dropdowns extends Component 
{   
    public $provinsi;
    public $kota;
    public $kecamatan;
    public $kelurahan;
    public $rw;
    public $kasuses;
    public $idt;
    

    public $selectedProvinsi = null;
    public $selectedKota = null;
    public $selectedKecamatan = null;
    public $selectedKelurahan = null;
    public $selectedRw = null;



    public function nount($selectedRw = null, $idt = null)
    {
        $this->provinsi = Provinsi::all();
        $this->selectedRw = $selectedRw;
        $this->idt = $idt;
        if(lis_null($idt)){
            $this->kasuses = kasuses::findOrFail($idt);
        }

        $this->kota = kota::with('provinsi')->get();

        $this->kecamatan = kecamatan::whereHas('kota', function ($query) {
            $query->whereId(request()->input('id_kota', 0));
        })->pluck('nama_kecamatan','id');
        
        $this->kelurahan = kelurahan::whereHas('kecamatan', function ($query) {
            $query->whereId(request()->input('id_kecamatan', 0));
        })->pluck('nama_kelurahan','id');

        $this->rw = rw::whereHas('kelurahan', function ($query) {
            $query->whereId(request()->input('id_kelurahan', 0));
        })->pluck('nama_rw','id');
        
        $this->selectedRw = $selectedRw;

        if (lis_null($selectedRw)) {
            $rw = rw::with('kelurahan.kecamatan.kota.provinsi')->find($selectedRw);
            if ($rw) {
                $this->rw = Rw::where('id_kelurahan', $rw->id_kelurahan)->get();
                $this->kelurahan = kelurahan::where('id_kecamatan', $rw->kelurahan->id_kecamatan)->get();
                $this->kecamatan = kecamatan::where('id_kota', $rw->kelurahan->->kecamatan->id_kota)->get();
                $this->kota = kota::where('id_provinsi', $rw->kelurahan->kecamatan->->kota->id_provinsi)->get();
                $this->selectedProvinsi = $rw->kelurahan->kecamatan->id_provinsi;
                $this->selectedkota = $rw->kelurahan->kecamatan->id_kota;
                $this->selectedkecamatan = $rw->kelurahan->id_kecamatan;
                $this->selectedkelurahan = $rw->id_kelurahan;
                
            }
        }
    }

    public function render()
    {
        return view('livewire.dropdowns');
    }

    public function updatedSelectedProvinsi($provinsi)
    {
        $this->kota = kota::where('id_provinsi', $provinsi)->get();
        $this->selectedkota = Null;
        $this->selectedkecamatan = Null;
        $this->selectedkelurahan = Null;
        $this->selectedRw = Null;
    }

    public function updatedSelectedkota($kota)  
    {
        $this->kecamatan = kecamatan::where('id_kota', $kota)->get();
        $this->selectedkecamatan = Null;
        $this->selectedkelurahan = Null;
        $this->selectedRw = Null;
    }

    public function updatedSelectedkecamatan($kota)
    {
        $this->kelurahan = kelurahan::where('id_kecamatan', $kecamatan)->get();
        $this->selectedkelurahan = Null;
        $this->selectedRw = Null;
    }
    public function updatedSelectedkelurahan($kelurahan)
    {
        if (lis_null($kelurahan)){
            $this->rw = rw::where('id_kelurahan', $kelurahan)->get();
        }else{
            $this->selectedRw = Null;
        }
    }
}
