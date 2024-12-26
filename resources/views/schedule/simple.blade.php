@extends('layout.layout')

@section('content')

<div class="container mt-3">
  <div class="row pt-4">
    @if (isset($schedule))
    <h2>Edit Jadwal</h2>
    @else
    <h2>Tambah Jadwal</h2>
    @endif
    <hr>
  </div>
  <div class="row">

    <div class="col-xl-4">
      <!-- Update -->
      @if (isset($schedule))
      <form action="{{ route('schedules.simple.update',['schedule' => $schedule->id]) }}" method="POST">
        @method('PUT')
        @csrf

        <div class="mb-3">
          <label class="form-label" for="device_id">Perangkat</label>
          <select class="form-select" name="device_id" id="device_id" value="{{ old('device_id') ?? $schedule->device_id}}">
            @forelse ($devices as $device)
            <option value="{{$device->id}}" {{ old('device_id') ?? $schedule->device_id == $device->id ? 'selected': '' }}>
              {{$device->name}}
            </option>
            @empty
            <option disabled> none </option>
            @endforelse
          </select>

          @error('device_id')
          <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label" for="name">Hari</label>
          <div class="row">

            <div class="col-6">
              <div class="form-check me-3">
                <input class="form-check-input" type="checkbox" value="Monday" name="days_monday" id="days-monday" @if (old('days_monday') || isset($scheduled_days['monday'])) checked @endif />
                <label class="form-check-label" for="days-monday">Senin</label>
              </div>
              <div class="form-check me-3">
                <input class="form-check-input" type="checkbox" value="Tuesday" name="days_tuesday" id="days-tuesday" @if (old('days_tuesday') || isset($scheduled_days['tuesday'])) checked @endif />
                <label class="form-check-label" for="days-tuesday">Selasa</label>
              </div>
              <div class="form-check me-3">
                <input class="form-check-input" type="checkbox" value="Wednesday" name="days_wednesday" id="days-wednesday" @if (old('days_wednesday') || isset($scheduled_days['wednesday'])) checked @endif />
                <label class="form-check-label" for="days-wednesday">Rabu</label>
              </div>
              <div class="form-check me-3">
                <input class="form-check-input" type="checkbox" value="Thursday" name="days_thursday" id="days-thursday" @if (old('days_thursday') || isset($scheduled_days['thursday'])) checked @endif />
                <label class="form-check-label" for="days-thursday">Kamis</label>
              </div>
            </div>

            <div class="col-6">
              <div class="form-check me-3">
                <input class="form-check-input" type="checkbox" value="Friday" name="days_friday" id="days-friday" @if (old('days_friday') || isset($scheduled_days['friday'])) checked @endif />
                <label class="form-check-label" for="days-friday">Jumat</label>
              </div>
              <div class="form-check me-3">
                <input class="form-check-input" type="checkbox" value="Saturday" name="days_saturday" id="days-saturday" @if (old('days_saturday') || isset($scheduled_days['saturday'])) checked @endif />
                <label class="form-check-label" for="days-saturday">Sabtu</label>
              </div>
              <div class="form-check me-3">
                <input class="form-check-input" type="checkbox" value="Sunday" name="days_sunday" id="days-sunday" @if (old('days_sunday') || isset($scheduled_days['sunday'])) checked @endif />
                <label class="form-check-label" for="days-sunday">Minggu</label>
              </div>
            </div>

          </div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="time">Jam</label>
          <input type="time" id="time" name="time" value="{{ old('time') ?? $schedule->time }}" class="form-control @error('time') is-invalid @enderror">
          @error('time')
          <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label" for="grams_per_feeding">Takaran Per Pakan</label>
          <div class="input-group">
            <input type="number" inputmode="numeric" id="grams_per_feeding" name="grams_per_feeding" value="{{ old('grams_per_feeding') ?? $schedule->grams_per_feeding  }}" class="form-control @error('grams_per_feeding') is-invalid @enderror">
            <span class="input-group-text">Gram</span>
          </div>
          @error('grams_per_feeding')
          <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <div class="form-check form-switch">
            <input name="active" value="1" type="checkbox" id="flexSwitchCheckChecked" class="form-check-input" @if (old('active') || $schedule->active) checked @endif>
            <label class="form-check-label" for="flexSwitchCheckChecked">Aktifkan Jadwal Ini</label>
          </div>
        </div>

        <button type="submit" class="btn btn-finbites-highlight mt-3 mb-2 w-100">Simpan</button>

        <!-- Add -->
        @else
        <form action="{{ route('schedules.simple.store') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label class="form-label" for="device_id">Perangkat</label>
            <select class="form-select" name="device_id" id="device_id" value="{{ old('device_id') }}">
              @forelse ($devices as $device)
              <option value="{{$device->id}}" {{ old('device_id') == $device->id ? 'selected': '' }}>
                {{$device->name}}
              </option>
              @empty
              <option disabled> none </option>
              @endforelse
            </select>

            @error('device_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label" for="name">Hari</label>
            <div class="row">

              <div class="col-6">
                <div class="form-check me-3">
                  <input class="form-check-input" type="checkbox" value="Monday" name="days_monday" id="days-monday" @if (old('days_monday')) checked @endif />
                  <label class="form-check-label" for="days-monday">Senin</label>
                </div>
                <div class="form-check me-3">
                  <input class="form-check-input" type="checkbox" value="Tuesday" name="days_tuesday" id="days-tuesday" @if (old('days_tuesday')) checked @endif />
                  <label class="form-check-label" for="days-tuesday">Selasa</label>
                </div>
                <div class="form-check me-3">
                  <input class="form-check-input" type="checkbox" value="Wednesday" name="days_wednesday" id="days-wednesday" @if (old('days_wednesday')) checked @endif />
                  <label class="form-check-label" for="days-wednesday">Rabu</label>
                </div>
                <div class="form-check me-3">
                  <input class="form-check-input" type="checkbox" value="Thursday" name="days_thursday" id="days-thursday" @if (old('days_thursday')) checked @endif />
                  <label class="form-check-label" for="days-thursday">Kamis</label>
                </div>
              </div>

              <div class="col-6">
                <div class="form-check me-3">
                  <input class="form-check-input" type="checkbox" value="Friday" name="days_friday" id="days-friday" @if (old('days_friday')) checked @endif />
                  <label class="form-check-label" for="days-friday">Jumat</label>
                </div>
                <div class="form-check me-3">
                  <input class="form-check-input" type="checkbox" value="Saturday" name="days_saturday" id="days-saturday" @if (old('days_saturday')) checked @endif />
                  <label class="form-check-label" for="days-saturday">Sabtu</label>
                </div>
                <div class="form-check me-3">
                  <input class="form-check-input" type="checkbox" value="Sunday" name="days_sunday" id="days-sunday" @if (old('days_sunday')) checked @endif />
                  <label class="form-check-label" for="days-sunday">Minggu</label>
                </div>
              </div>

            </div>
          </div>

          <div class="mb-3">
            <label class="form-label" for="time">Jam</label>
            <input type="time" id="time" name="time" value="{{ old('time') }}" class="form-control @error('time') is-invalid @enderror">
            @error('time')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label" for="grams_per_feeding">Takaran Per Pakan</label>
            <div class="input-group">
              <input type="number" inputmode="numeric" id="grams_per_feeding" name="grams_per_feeding" value="{{ old('grams_per_feeding') }}" class="form-control @error('grams_per_feeding') is-invalid @enderror">
              <span class="input-group-text">Gram</span>
            </div>
            @error('grams_per_feeding')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <div class="form-check form-switch">
              <input name="active" value="1" type="checkbox" id="flexSwitchCheckChecked" class="form-check-input" checked>
              <label class="form-check-label" for="flexSwitchCheckChecked">Aktifkan Jadwal Ini</label>
            </div>
          </div>

          <button type="submit" class="btn btn-finbites-highlight mt-3 mb-2 w-100">Tambahkan</button>
          @endif

        </form>
        <hr>

    </div>

    <!-- ------------------------------- -->
    <!-- <div class="row"> -->

    <div class="col-xl-8">

      <table class="table table-striped">
        <thead>
          <tr class="highlight">
            <th>#</th>
            <th>Perangkat</th>
            <th class="d-finbites-sm-none">Hari</th>
            <th>Jam</th>
            <th class="d-finbites-sm-none">Gram/Pemberian Pakan</th>
            <th class="d-finbites-sm-none">Status</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($schedules as $schedule)
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
            <td class="d-finbites-sm-none">{{$schedule->grams_per_feeding}}</td>
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
                  <a href="{{ route('schedules.simple.edit', ['schedule' => $schedule->id]) }}" class="btn btn-finbites-edit"><i class="lni lni-pencil"></i></a>
                </div>
                <div>
                  <!-- <a href="{{ route('schedules.simple.destroy', $schedule->id) }}" class="btn btn-finbites-delete" data-confirm-delete="true"><i class="lni lni-trash-can"></i></a> -->
                  <form action="{{ route('schedules.simple.destroy', $schedule->id) }}" method="POST" class="d-inline" data-confirm-delete="true">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-finbites-delete"><i class="lni lni-trash-can"></i></button>
                  </form>
                </div>
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
</div>

@endsection