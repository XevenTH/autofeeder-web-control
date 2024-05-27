@extends('layout.layout')

@section('content')

  <div class="container mt-3">
    <!-- <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ubah</li>
          </ol>
        </nav>
      </div>
    </div> -->
    <div class="row">
      <div class="col-md-8 col-xl-6 py-4">
        <h2>Ubah Data User</h2>
        <hr>
        <form action="{{ route('users.update',['user' => $user->id]) }}" method="POST">
          @method('PUT')
          @csrf
          
          <div class="mb-3">
            <label class="form-label" for="name">Nama</label>
            <input type="text" id="name" name="name" value="{{ old('name') ?? $user->name }}" class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary mb-2">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>

@endsection