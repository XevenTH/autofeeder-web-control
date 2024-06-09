@extends('layout.auth')

@section('content')

<div class="row d-flex align-items-center">

  <div class="col-md-8 col-xl-8 py-4">
    <p class="fs-4 fw-bold">FinBites: Autofeeder Monitoring</p>
    <p>FinBites memastikan ikan Anda mendapatkan makanan tepat waktu, bahkan ketika kita sibuk. Jadwal yang terprogram dan kontrol porsi membuat teman-teman Anda tetap sehat dan bahagia, apa pun yang terjadi."</p>
  </div>
  
  <div class="col-md-4 col-xl-4 py-4 bg-white text-dark rounded-4 p-5">
    <h2 class="mb-3">Kata Sandi Baru</h2>

    <form action="{{ route('passreset.post') }}" method="POST">
      @csrf

      <div class="mb-3">
        <input type="email" id="email" name="email" placeholder="Alamat email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="input-group mb-3">
        <input type="password" id="password" name="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror" placeholder="Kata Sandi Baru">
        <span class="input-group-text rounded-end-2">
          <i id="togglePassword" class="bi bi-eye-slash"></i>
        </span>
        @error('password')
        <div class="mt-1 invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="input-group mb-5">
        <input type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Konfirmasi Kata Sandi Baru">
        <span class="input-group-text rounded-end-2">
          <i id="togglePasswordConfirmation" class="bi bi-eye-slash"></i>
        </span>
        @error('password_confirmation')
        <div class="mt-1 invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary mb-2 w-100 btn-finbites-hover">Simpan</button>
      <p class="S1 fs-6 mb-2">Atur ulang kata sandi.</p>
    </form>
  </div>
</div>

@endsection