@extends('layout.layout')

@section('content')

<div class="container mt-3">

  <div class="row pt-4 text-center">
    <h2>Selamat datang di FinBites!</h2>
    <h6>Situs pemantauan dan pengaturan autofeeder.</h6>
    <hr>
  </div>

  <div class="row">
    <div class="col-12 col-md-4">
      <a href="{{ route('devices.simple') }}">
        <div class="card border-0">
          <div class="card-body py-4 d-flex justify-content-between">
            <span class="fw-bold fs-5">
              Jumlah Perangkat
            </span>
            <span class="badge fb-text-bg-primary me-2 fs-5 py-auto">
              {{ count($devices) }}
            </span>
          </div>
        </div>
      </a>
    </div>

    <div class="col-12 col-md-4">
      <a href="{{ route('schedules.simple') }}">
        <div class="card border-0">
          <div class="card-body py-4 d-flex justify-content-between">
            <span class="fw-bold fs-5">
              Jadwal Terdaftar
            </span>
            <span class="badge fb-text-bg-primary me-2 fs-5 py-auto">
              {{ count($schedules) }}
            </span>
          </div>
        </div>
      </a>
    </div>

    <div class="col-12 col-md-4">
      <a href="{{ route('schedules.simple') }}">
        <div class="card border-0">
          <div class="card-body py-4 d-flex justify-content-between">
            <span class="fw-bold fs-5">
              Jadwal Aktif
            </span>
            <span class="badge fb-text-bg-primary me-2 fs-5 py-auto">
              {{ count($active_schedules) }}
            </span>
          </div>
        </div>
      </a>
    </div>
  </div>

  <div class="row">

    <div class="col-12 col-md-6">
      <a href="{{ route('schedules.simple') }}">
        <div class="card border-0 fb-bg-gradient">
          <div class="card-body py-4 d-flex justify-content-center">
            @include('home.clock')
          </div>
        </div>
      </a>
    </div>

    <div class="col-12 col-md-6">

      <table class="table table-striped mt-3">
        <thead>
          <tr class="highlight">
            <th>#</th>
            <th>Perangkat</th>
            <th class="d-finbites-sm-none">Hari</th>
            <th>Jam</th>
            <th class="d-finbites-sm-none">Status</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($active_schedules as $schedule)
          <tr>
            <th>{{$loop->iteration}}</th>

            <td class="d-finbites-sm-none">{{$schedule->name}}</td>
            <!-- untuk tampilan mobile -->
            <td class="d-finbites-sm-table-cell">{{Str::limit($schedule->name, 9)}}</td>

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
            <td class="d-finbites-sm-none">
              @if ($schedule->active == 1)
              <span class="badge text-bg-success rounded-pill">AKTIF</span>
              @else
              <span class="badge text-bg-secondary rounded-pill">TIDAK<br>AKTIF</span>
              @endif
            </td>
            <td>
              <div>
                <a href="{{ route('schedules.simple.edit', ['schedule' => $schedule->id]) }}" class="btn btn-finbites-edit"><i class="lni lni-pencil"></i></a>
              </div>
            </td>
          </tr>
          @empty
          <td colspan="8" class="text-center">Tidak ada jadwal yang dibuat...</td>
          @endforelse
        </tbody>
      </table>
    </div>

  </div>
  
  <div class="row">

    @forelse ($devices as $device)
    <div class="@if (count($devices) < 2)
                col-12
                @elseif (count($devices) == 2 )
                col-12 col-md-6
                @elseif (count($devices) > 2 )
                col-12 col-md-4
                @endif
                ">
      <a href="{{ route('devices.simple.edit',['device' => $device->id]) }}">
        <div class="card border-0">
          <div class="card-body py-4">
            <div class="d-flex justify-content-between">
              <span class="fw-bold fs-5">
                {{Str::limit($device->name, 20)}}
              </span>

              <span class="fw-bold fs-5">
                {{ $device->capacity }}%
              </span>
            </div>
            <div class="progress w-100">
              <div class="progress-bar progress-bar-striped progress-bar-animated
                           @if ($device->capacity <= 15) 
                            bg-danger 
                          @elseif ($device->capacity <= 30) 
                            bg-orange
                          @else
                            bg-success
                          @endif" role="progressbar" aria-valuenow="{{ $device->capacity }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $device->capacity }}%"></div>
            </div>
          </div>
        </div>
      </a>
    </div>
    @empty
    <div class="col-12">
      <a href="{{ route('devices.simple') }}">
        <div class="card border-0">
          <div class="card-body py-4 d-flex justify-content-center">
            <span class="fw-bold fs-5">
              Tidak Ada Perangkat Terdaftar!
            </span>
          </div>
        </div>
      </a>
    </div>
    @endforelse

  </div>

</div>

@endsection