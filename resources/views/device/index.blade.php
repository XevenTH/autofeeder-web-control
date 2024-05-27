@extends('layout.layout')

@section('content')

  <div class="container mt-3">
    <!-- <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Device</li>
          </ol>
        </nav>
      </div>
    </div> -->
    <div class="row">
      <div class="col-12">
        <div class="py-4 d-flex justify-content-between align-items-center">
          <h2>Tabel Device</h2>
          <a href="{{ route('devices.create') }}" class="btn btn-primary">
            Tambah Device
          </a>
        </div>
        @if(session()->has('pesan'))
        <div class="alert alert-success">
          {{ session()->get('pesan')}}
        </div>
        @endif<table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Id User</th>
              <th>Nama</th>
              <th>Topik</th>
              <th>Kapasitas</th>
              <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($devices as $device)
            <tr>
              <th>{{$loop->iteration}}</th>
              <td>{{$device->user_id}}</td>
              <td>{{$device->name}}</td>
              <td>{{$device->topic}}</td>
              <td>{{$device->capacity}}</td>
              <td>
                <a href="{{ route('devices.edit', ['device' =>$device->id]) }}" class="btn btn-dark">Ubah</a>
                <a href="{{ route('devices.destroy', ['device' =>$device->id]) }}" class="btn btn-danger">Hapus</a>
              </td>
            </tr>
            @empty
            <td colspan="6" class="text-center">Tidak ada data...</td>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection