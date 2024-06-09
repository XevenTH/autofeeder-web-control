@extends('layout.layout')

@section('content')

<div class="container mt-3">
  <div class="row">
    <div class="col">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Data Pengguna</a></li>
          <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8 col-xl-6 py-4">
      <h2>Tambah Data Pengguna</h2>
      <hr>
      <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label class="form-label" for="name">Nama</label>
          <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
          @error('name')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label" for="email">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
          @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label" for="phone">No. Telp</label>
          <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror">
          @error('phone')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label" for="password">Password</label>
          <div class="input-group">
            <input type="password" id="password" name="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror">
            <span class="input-group-text rounded-end-2">
              <i id="togglePassword" class="bi bi-eye-slash"></i>
            </span>
            @error('password')
            <div class="mt-1 invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="input-group mb-3">
          <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
          <div class="input-group">
            <input type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control @error('password_confirmation') is-invalid @enderror">
            <span class="input-group-text rounded-end-2">
              <i id="togglePasswordConfirmation" class="bi bi-eye-slash"></i>
            </span>
            @error('password_confirmation')
            <div class="mt-1 invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <button type="submit" class="btn btn-finbites-highlight mt-3 mb-2">Tambahkan</button>
      </form>
    </div>
  </div>
</div>

@endsection