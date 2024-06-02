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
          <h2>Tabel Data Jadwal</h2>
          <a href="{{ route('schedules.create') }}" class="btn btn-primary">
            Tambah Jadwal
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
              <th>Id Perangkat</th>
              <th>Hari</th>
              <th>Jam</th>
              <th>Gram/Pemberian Pakan</th>
              <th>Detik Servo Terbuka</th>
              <th>Status</th>
              <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($schedules as $schedule)
            <tr>
              <th>{{$loop->iteration}}</th>
              <td>{{$schedule->device_id}}</td>
              <td>{{$schedule->days}}</td>
              <td>{{$schedule->time}}</td>
              <td>{{$schedule->grams_per_feeding}}</td>
              <td>{{$schedule->servo_seconds}}</td>
              <td>
                @if ($schedule->active == 1)
                  <span class="badge text-bg-success rounded-pill">AKTIF</span>
                @else
                  <span class="badge text-bg-secondary rounded-pill">TIDAK<br>AKTIF</span>
                @endif
              </td>
              <td>
                <div class="d-flex">
                  <a href="{{ route('schedules.edit',['schedule' => $schedule->id]) }}" class="btn btn-dark">Edit</a>
                  <form method="POST" action="{{ route('schedules.destroy', ['schedule' => $schedule->id]) }}">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger ms-3">Hapus</button>
                  </form>
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