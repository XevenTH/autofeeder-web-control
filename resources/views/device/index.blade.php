@extends('layout.layout')

@section('content')

  <div class="container mt-3">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Data Perangkat</li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="py-4 d-flex justify-content-between align-items-center">
          <h2>Tabel Data Perangkat</h2>
          <a href="{{ route('devices.create') }}" class="btn btn-finbites-highlight">
            Tambah Perangat
          </a>
        </div>
        @if(session()->has('pesan'))
        <div class="alert alert-success">
          {{ session()->get('pesan')}}
        </div>
        @endif<table class="table table-striped">
          <thead>
            <tr class="highlight">
              <th>#</th>
              <th class="d-finbites-sm-none">Id Pengguna</th>
              <td class="d-finbites-sm-table-header">Id Pengu...</td>
              <!-- untuk tampilan mobile -->
              <th>Nama</th>
              <th class="d-finbites-sm-none">Topik</th>
              <th class="d-finbites-sm-none">Kapasitas (Cm)</th>
              <th class="d-finbites-sm-none">(Persentase)</th>
              <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($devices as $device)
            <tr>
              <th>{{$loop->iteration}}</th>
              <td>{{$device->user_id}}</td>
              <td>{{$device->name}}</td>
              <td class="d-finbites-sm-none">{{$device->topic}}</td>              
              <td class="d-finbites-sm-none">{{$device->capacity}}</td>
              <td class="d-finbites-sm-none">{{Str::substr((100 - ((($device->capacity - 2) / 10) * 100 )), 0, 4)}}%</td>
              <td>

                <div class="d-flex">
                  <div class="pe-3">
                  <a href="{{ route('devices.edit',['device' => $device->id]) }}" class="btn btn-finbites-edit"><i class="lni lni-pencil"></i></a>
                  </div>
                  <div>
                    <!-- <a href="{{ route('devices.destroy',['device' => $device->id]) }}" class="btn btn-finbites-delete" data-confirm-delete="true"><i class="lni lni-trash-can"></i></a> -->
                    <form action="{{ route('devices.destroy',['device' => $device->id]) }}" method="POST" class="d-inline" data-confirm-delete="true">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-finbites-delete"><i class="lni lni-trash-can"></i></button>
                    </form>
                  </div>
                </div>

              </td>
            </tr>
            @empty
            <td colspan="7" class="text-center">Tidak ada data...</td>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection