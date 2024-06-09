@extends('layout.auth')

@section('content')

<div class="row d-flex align-items-center">

  <div class="col-md-6 col-lg-8 py-4">
    <p class="fs-4 fw-bold">FinBites: Autofeeder Monitoring</p>
    <p>FinBites memastikan ikan Anda mendapatkan makanan tepat waktu, bahkan ketika kita sibuk. Jadwal yang terprogram dan kontrol porsi membuat teman-teman Anda tetap sehat dan bahagia, apa pun yang terjadi."</p>
  </div>

  <div class="col-md-6 col-lg-4 py-4 bg-white text-dark rounded-4 p-5">
    <h2 class="mb-3">Masuk</h2>

    <form action="{{ route('login.post') }}" method="POST">
      @csrf

      <div class="mb-3">
        <input type="email" id="email" name="email" placeholder="Alamat email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
        @error('email')
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

      <div class="mb-2 fs-5" id="forgot-password">
        <a href="{{ route('recovery') }}" class="text-decoration-none font-small" style="color:#0D4A59">Lupa kata sandi?</a>
      </div>

      <button type="submit" class="btn btn-primary mb-2 w-100 btn-finbites-hover">Masuk</button>
    </form>
    <p class="S1 fs-6 mb-2">Belum punya akun? <a href="{{ route('register') }}" style="color:#0D4A59">Daftar</a></p>
  </div>

</div>

@endsection