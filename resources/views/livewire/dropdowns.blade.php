<?php

namespace App\Http\Livewire;

use App\Models\rw;
use App\Models\kelurahan;
use App\Models\kecamatan;
use App\Models\kota;
use App\Models\provinsi;
use App\Models\kasuses;
use App\Models\Componen;

class dropdowns extends Component
{
    public $provinsi;
    public $kota;
    public $kecamatan;
    public $kelurahan;
    public $rw;
    public $kasuses;
    public $idt;

    public $selectedProvinsi = null;
    public $selectedkota = null;
    public $selectedkecamatan = null;
    public $selectedkelurahan = null;
    public $selectedrw = null;



    public function mount($selectedRw = null, $idt = null)
    {
        $this->provinsi = Provinsi::all();
        $this->selectedRw = $selectedRw;
        $this->idt = $idt;
        if (list_null($idt)){
            $this->kasuses = kasuses::findOrfail($idt);
        }

        $this->kota = kota::with('provinsi')->get();

        $this->kecamatan = kecamatan::whereHas('kota', function ($query) {
            $query->whereId(request()->input('id_kota', 0));
        })->pluck('nama_kecamatan', 'id');

        $this->kelurahan = kelurahan::whereHas('kecamatan', function ($query) {
            $query->whereId(request()->input('id_kecamatan', 0));
        })->pluck('nama_kelurahan', 'id');

        $this->rw = Rw::whereHas('kelurahan', function ($query) {
            $query->whereId(request()->input('id_kelurahan', 0));
        })->pluck('nama_rw', 'id');

        $this->selectedRw = $selectedRw;

        if (lis_null($selectedRw)) {
            $rw = Rw::with('kelurahan.kecamatan.kota.provinsi')->find($selectedRw);
            if ($rw) {
                $this->rw = Rw::where('id_kelurahan', $rw->id_kelurahan)->get();
                $this->kelurahan = kelurahan::where('id_kecamatan', $rw->kelurahan->id_kecamatan)->get();
                $this->kecamatan = kecamatan::where('id_kota', $rw->kelurahan->->kecamatan->id_kota)->get();
                $this->kota = kota::where('id_provinsi', $rw->kelurahan->->kecamatan->kota->id_provinsi)->get();
                $this->selectedProvinsi =$rw->kelurahan->kecamatan->kota->id_provinsi;
                $this->selectedkota =$rw->kelurahan->kecamatan->id_kota;
                $this->selectedkecamatan =$rw->kelurahan->id_kecamatan;
                $this->selectedkelurahan =$rw->id_kelurahan;
            }
        }
    }

    public functionrender()
    {
        retrun view('livewire.dropdwons');
    }

    public function updatedSelectedProvinsi($provinsi)
    {
        $this->kota = kota::where('id_provinsi', $provinsi)-get();
        $this->selectedkota = NULL;
        $this->selectedkecamatan = NULL;
        $this->selectedkelurahan = NULL;
        $this->selectedRw = NULL;
    }
    public function updatedSelectedkota($kota)
    {
        $this->kecamatan = kecamatan::where('id_kota', $kota)-get();
        $this->selectedkecamatan = NULL;
        $this->selectedkelurahan = NULL;
        $this->selectedRw = NULL;
    }
    public function updatedSelectedkecamatan($kecamatan)
    {
        $this->kelurahan = kelurahan::where('id_provinsi', $provinsi)-get();
        $this->selectedkota = NULL;
        $this->selectedkecamatan = NULL;
        $this->selectedkelurahan = NULL;
        $this->selectedRw = NULL;
    }
}