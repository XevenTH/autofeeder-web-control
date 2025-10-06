@extends('layout.layout')

@section('content')

  <div class="container mt-3">
    <div class="row pt-4">
      @if (isset($device))
        <h2>Edit Perangkat</h2>
      @else
        <h2>Tambah Perangkat</h2>
      @endif
      <hr>
    </div>
    <div class="row">
      <div class="col-xl-4">
      
        @if (isset($device))
        <form action="{{ route('devices.simple.update',['device' => $device->id]) }}" method="POST">
          @method('PUT')
          @csrf
          <div class="mb-3">
            <label class="form-label" for="name">Nama Perangkat</label>
            <input type="text" id="name" name="name" value="{{ old('name') ?? $device->name }}" class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="mb-3">
            <label class="form-label" for="topic">Topik</label>
            <input type="text" id="topic" name="topic" value="{{ old('topic') ?? $device->topic }}" class="form-control @error('topic') is-invalid @enderror">
            @error('topic')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-finbites-highlight mt-3 mb-2 w-100">Simpan</button>
          
        @else
        <form action="{{ route('devices.simple.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label" for="name">Nama Perangkat</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="(Isi untuk mendaftarkan perangkat baru)">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="mb-3">
            <label class="form-label" for="topic">Topik</label>
            <input type="text" id="topic" name="topic" value="{{ old('topic') }}" class="form-control @error('topic') is-invalid @enderror" placeholder="(Isi untuk mendaftarkan perangkat baru)">
            @error('topic')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-finbites-highlight mt-3 mb-2 w-100">Tambahkan</button>
        @endif


        </form>
        <hr>
      </div>
    <!-- </div> -->
    <!-- ---------------------------- -->
    <!-- <div class="row"> -->
      <div class="col-xl-8">

        <table class="table table-striped">
          <thead>
            <tr class="highlight">
              <th>#</th>
              <th>Nama</th>
              <th class="d-finbites-sm-none">Topik</th>
              <th>Kapasitas</th>
              <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($devices as $d)
            <tr>
              <th>{{$loop->iteration}}</th>
              <td class="d-finbites-sm-none">{{$d->name}}</td>
              <!-- untuk tampilan mobile -->
              <td class="d-finbites-sm-table-cell">{{Str::limit($d->name, 4)}}</td>
              <td class="d-finbites-sm-none">{{$d->topic}}</td>
              <td>{{Str::substr((100 - ((($d->capacity - 2) / 10) * 100 )), 0, 4)}}%</td>
              <td>

                <div class="d-flex">
                  <div class="pe-3">
                  <a href="{{ route('devices.simple.edit',['device' => $d->id]) }}" class="btn btn-finbites-edit"><i class="lni lni-pencil"></i></a>
                  </div>
                  <div>
                    <form id="delete-form-{{ $d->id }}" action="{{ route('devices.simple.destroy', ['device' => $d->id]) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <a href="#" class="btn btn-finbites-delete" onclick="confirmDelete({{ $d->id }})">
                        <i class="lni lni-trash-can"></i>
                    </a>
                  </div>
                </div>

              </td>
            </tr>
            @empty
            <td colspan="6" class="text-center">Tidak ada perangkat yang terdaftar...</td>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection