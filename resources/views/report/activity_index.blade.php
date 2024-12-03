@extends('layout.layout')

@section('content')

  <div class="container mt-3">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Data Aktivitas</li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="py-4 d-flex justify-content-between align-items-center">
          <h2>Tabel Data Aktivitas</h2>
          <a href="{{ route('report.activity.export') }}" class="btn btn-finbites-highlight">
            Expor Data
          </a>
        </div>
        <!-- @if(session()->has('pesan'))
        <div class="alert alert-success">
          {{ session()->get('pesan')}}
        </div>
        @endif -->
        <table class="table table-striped">
          <thead>
            <tr class="highlight">
              <!-- <th>#</th> -->
              <th class="d-finbites-sm-none">Id</th>
              <th class="d-finbites-sm-none">Log</th>
              <th class="d-finbites-sm-none">Tanggal Waktu</th>
              <th>Subjek</th>
              <th>Deskripsi</th>
              <th>Aktivitas</th>
              <th>Id Pengguna</th>
              <!-- <th class="d-finbites-sm-none">Sebelum</th>
              <th class="d-finbites-sm-none">Sesudah</th> -->
              <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($activities as $activity)
            <tr>
              <!-- <th>{{$loop->iteration}}</th> -->
              <td class="d-finbites-sm-none">{{$activity->id}}</td>
              <td class="d-finbites-sm-none">{{$activity->log_name}}</td>
              <td class="d-finbites-sm-none">{{$activity->created_at}}</td>
              <td>{{$activity->subject_type}}</td>
              <td>{{$activity->description}}</td>
              <td>{{$activity->event}}</td>
              <td>{{$activity->causer_id}}</td>
              <!-- <td class="d-finbites-sm-none">{{$activity->old}}</td>
              <td class="d-finbites-sm-none">{{$activity->attributes}}</td> -->
              <td>

                <div class="d-flex">
                  <div class="pe-3">
                  <!-- <a href="{{ route('report.activity.detail', ['activity' => $activity->id]) }}" class="btn btn-finbites-edit"><i class="lni lni-pencil"></i></a> -->
                    <a href="#" class="btn btn-finbites-edit" style="font-weight: bold;">...</a>
                  </div>
                </div>
                
              </td>
            </tr>
            @empty
            <td colspan="8" class="text-center">Tidak ada data...</td>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection