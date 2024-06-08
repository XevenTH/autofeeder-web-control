@extends('layout.layout')

@section('content')

  <div class="container mt-3">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Data Jadwal</li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="py-4 d-flex justify-content-between align-items-center">
          <h2>Tabel Data Jadwal</h2>
          <a href="{{ route('schedules.create') }}" class="btn btn-finbites-highlight">
            Tambah Jadwal
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
              <th>Id Perangkat</th>
              <th class="d-finbites-sm-none">Hari</th>
              <th>Jam</th>
              <th class="d-finbites-sm-none">Gram/Pemberian Pakan</th>
              <th class="d-finbites-sm-none">Detik Servo Terbuka</th>
              <th class="d-finbites-sm-none">Status</th>
              <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($schedules as $schedule)
            <tr>
              <th>{{$loop->iteration}}</th>
              <td>{{$schedule->device_id}}</td>
              <td class="d-finbites-sm-none">
                @forelse (explode(' ', $schedule->days) as $day)
                @if ($day == '-')
                <span class="badge text-bg-warning rounded-pill">Kiamat</span>
                @elseif ($day == 'Monday')
                <span class="badge fb-text-bg-primary rounded-pill">Senin</span>
                @elseif ($day == 'Tuesday')
                <span class="badge fb-text-bg-primary rounded-pill">Selasa</span>
                @elseif ($day == 'Wednesday')
                <span class="badge fb-text-bg-primary rounded-pill">Rabu</span>
                @elseif ($day == 'Thursday')
                <span class="badge fb-text-bg-primary rounded-pill">Kamis</span>
                @elseif ($day == 'Friday')
                <span class="badge fb-text-bg-primary rounded-pill">Jumat</span>
                @elseif ($day == 'Saturday')
                <span class="badge fb-text-bg-primary rounded-pill">Sabtu</span>
                @elseif ($day == 'Sunday')
                <span class="badge fb-text-bg-primary rounded-pill">Minggu</span>
                @endif
                
                @empty

                @endforelse
              </td>
              <td>{{Str::substr($schedule->time, 0, 5)}}</td>
              <td class="d-finbites-sm-none">{{$schedule->grams_per_feeding}}</td>
              <td class="d-finbites-sm-none">{{$schedule->servo_seconds}}</td>
              <td class="d-finbites-sm-none">
                @if ($schedule->active == 1)
                  <span class="badge text-bg-success rounded-pill">AKTIF</span>
                @else
                  <span class="badge text-bg-secondary rounded-pill">TIDAK<br>AKTIF</span>
                @endif
              </td>
              <td>

                <div class="d-flex">
                  <div class="pe-3">
                    <a href="{{ route('schedules.edit', ['schedule' => $schedule->id]) }}" class="btn btn-finbites-edit"><i class="lni lni-pencil"></i></a>
                  </div>
                  <div>
                    <a href="{{ route('schedules.destroy', $schedule->id) }}" class="btn btn-finbites-delete" data-confirm-delete="true"><i class="lni lni-trash-can"></i></a>
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