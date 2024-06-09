@extends('layout.layout')

@section('content')

  <div class="container mt-3">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('schedules.index') }}">Data Jadwal</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ubah</li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 col-xl-6 py-4">
        <h2>Edit Data Jadwal</h2>
        <hr>
        <form action="{{ route('schedules.update',['schedule' => $schedule->id]) }}" method="POST">
          @method('PUT')
          @csrf
          
          <div class="mb-3">
            <label class="form-label" for="device_id">Perangkat</label>
            <select class="form-select" name="device_id" id="device_id" value="{{ old('device_id') ?? $schedule->device_id}}">
            @forelse ($devices as $device)
              <option value="{{$device->id}}" {{ old('device_id') ?? $schedule->device_id == $device->id ? 'selected': '' }}>
                {{$device->id}} - {{$device->name}}
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
                  <input class="form-check-input" type="checkbox" value="Monday" name="days_monday" id="days-monday" @if (old('days_monday') || isset($scheduled_days['monday'])) checked @endif/>
                  <label class="form-check-label" for="days-monday">Senin</label>
                </div>
                <div class="form-check me-3">
                  <input class="form-check-input" type="checkbox" value="Tuesday" name="days_tuesday" id="days-tuesday" @if (old('days_tuesday') || isset($scheduled_days['tuesday'])) checked @endif/>
                  <label class="form-check-label" for="days-tuesday">Selasa</label>
                </div>
                <div class="form-check me-3">
                  <input class="form-check-input" type="checkbox" value="Wednesday" name="days_wednesday" id="days-wednesday" @if (old('days_wednesday') || isset($scheduled_days['wednesday'])) checked @endif/>
                  <label class="form-check-label" for="days-wednesday">Rabu</label>
                </div>
                <div class="form-check me-3">
                  <input class="form-check-input" type="checkbox" value="Thursday" name="days_thursday" id="days-thursday" @if (old('days_thursday') || isset($scheduled_days['thursday'])) checked @endif/>
                  <label class="form-check-label" for="days-thursday">Kamis</label>
                </div>
              </div>

              <div class="col-6">
                <div class="form-check me-3">
                  <input class="form-check-input" type="checkbox" value="Friday" name="days_friday" id="days-friday" @if (old('days_friday') || isset($scheduled_days['friday'])) checked @endif/>
                  <label class="form-check-label" for="days-friday">Jumat</label>
                </div>
                <div class="form-check me-3">
                  <input class="form-check-input" type="checkbox" value="Saturday" name="days_saturday" id="days-saturday" @if (old('days_saturday') || isset($scheduled_days['saturday'])) checked @endif/>
                  <label class="form-check-label" for="days-saturday">Sabtu</label>
                </div>
                <div class="form-check me-3">
                  <input class="form-check-input" type="checkbox" value="Sunday" name="days_sunday" id="days-sunday" @if (old('days_sunday') || isset($scheduled_days['sunday'])) checked @endif/>
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
              <input type="number" id="grams_per_feeding" name="grams_per_feeding" value="{{ old('grams_per_feeding') ?? $schedule->grams_per_feeding  }}" class="form-control @error('grams_per_feeding') is-invalid @enderror">
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

          <button type="submit" class="btn btn-finbites-highlight mt-3 mb-2">Simpan</button>
        </form>
      </div>
    </div>
  </div>

@endsection