@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Ubah Daftar Kasus</div>
                <div class="card-body">
                    <form action="{{route('kasus.update',$kasus->id)}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label>Jumlah Positif</label>
                            <input type="number" name="positif" class="form-control" value="{{ $kasus->positif }}" placeholder="Jumlah Positif" required autofocus>
                            <label>Jumlah Sembuh</label>
                            <input type="number" name="sembuh" class="form-control" value="{{ $kasus->sembuh }}" placeholder="Jumlah Sembuh" required >
                            <label>Jumlah Meninggal</label>
                            <input type="number" name="meninggal" class="form-control" value="{{ $kasus->meninggal }}" placeholder="Jumlah Meninggal" required >
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ $kasus->tanggal }}" placeholder="Tanggal" required>
                            <label>Nomor Rw</label>
                            <select name="rw_id" class="form-control" required>
                                @foreach ($rw as $data)
                                <option value="{{$data->id}}" {{$data->id == $kasus->rw_id ? 'selected' : ''}} >{{$data->nama_rw}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection