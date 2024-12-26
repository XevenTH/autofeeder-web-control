@extends('layout.layout')

@section('content')

<div class="container mt-3">
  <div class="row">
    <div class="col-md-8 col-xl-6 py-4">
      <h2>Edit Profil</h2>
      <hr>
      <form action="{{ route('users.simple.update',['user' => $user->id]) }}" method="POST">
        @method('PUT')
        @csrf

        <input type="hidden" name="id" value="{{ $user->id }}">
        <input type="hidden" name="password" value="{{ $user->password }}">

        <div class="mb-3">
          <label class="form-label" for="name">Nama</label>
          <input type="text" id="name" name="name" value="{{ old('name') ?? $user->name }}" class="form-control @error('name') is-invalid @enderror">
          @error('name')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label" for="email">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') ?? $user->email }}" class="form-control @error('email') is-invalid @enderror">
          @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label" for="phone">No. Telp</label>
          <input type="text" inputmode="numeric" id="phone" name="phone" value="{{ old('phone') ?? $user->phone }}" class="form-control @error('phone') is-invalid @enderror">
          @error('phone')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label" for="password">Password Baru</label>
          <div class="input-group">
            <input type="password" id="password" name="newpassword" value="{{ old('newpassword') ?? $user->newpassword }}" class="form-control @error('newpassword') is-invalid @enderror" placeholder="(Isi bila ingin mengganti password)">
            <span class="input-group-text rounded-end-2">
              <i id="togglePassword" class="bi bi-eye-slash"></i>
            </span>
            @error('newpassword')
            <div class="mt-1 invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
          <div class="input-group">
            <input type="password" id="password_confirmation" name="newpassword_confirmation" value="{{ old('newpassword_confirmation') ?? $user->newpassword_confirmation}}" class="form-control @error('newpassword_confirmation') is-invalid @enderror" placeholder="(Isi bila ingin mengganti password)">
            <span class="input-group-text rounded-end-2">
              <i id="togglePasswordConfirmation" class="bi bi-eye-slash"></i>
            </span>
            @error('newpassword_confirmation')
            <div class="mt-1 invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <button type="submit" class="btn btn-finbites-highlight mt-3 mb-2">Simpan</button>
      </form>
    </div>
  </div>
</div>

@endsection