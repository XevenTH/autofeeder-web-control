@extends('layout.auth')

@section('content')

<div class="row d-flex align-items-center">

  <div class="col-md-6 col-lg-8 py-4">
    <p class="fs-4 fw-bold">FinBites: Autofeeder Monitoring</p>
    <p>FinBites memastikan ikan Anda mendapatkan makanan tepat waktu, bahkan ketika kita sibuk. Jadwal yang terprogram dan kontrol porsi membuat teman-teman Anda tetap sehat dan bahagia, apa pun yang terjadi."</p>
  </div>

  <div class="col-md-6 col-lg-4 py-4 bg-white text-dark rounded-4 p-5">
    <h2 class="mb-3">Daftar</h2>

    <form action="{{ route('register.post') }}" method="POST">
      @csrf

      <div class="mb-3">
        <input type="name" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Pengguna">
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Alamat Email">
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <input type="phone" id="phone" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="No. Telp (081234567890)">
        @error('phone')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="input-group mb-3">
        <input type="password" id="password" name="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror" placeholder="Kata Sandi">
        <span class="input-group-text rounded-end-2">
          <i id="togglePassword" class="bi bi-eye-slash"></i>
        </span>
        @error('password')
        <div class="mt-1 invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="input-group mb-5">
        <input type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Konfirmasi Kata Sandi">
        <span class="input-group-text rounded-end-2">
          <i id="togglePasswordConfirmation" class="bi bi-eye-slash"></i>
        </span>
        @error('password_confirmation')
        <div class="mt-1 invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary mb-2 w-100 btn-finbites-hover">Daftar</button>
      <p class="S1 fs-6 mb-2">Sudah punya akun? <a href="{{ route('login') }}" style="color:#0D4A59">Masuk</a></p>
    </form>
  </div>

</div>

@endsection