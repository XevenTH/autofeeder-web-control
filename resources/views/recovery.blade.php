@extends('layout.auth')

@section('content')

<div class="row d-flex align-items-center">

  <div class="col-md-8 col-xl-8 py-4">
    <p class="fs-4 fw-bold">FinBites: Autofeeder Monitoring</p>
    <p>FinBites memastikan ikan Anda mendapatkan makanan tepat waktu, bahkan ketika kita sibuk. Jadwal yang terprogram dan kontrol porsi membuat teman-teman Anda tetap sehat dan bahagia, apa pun yang terjadi."</p>
  </div>
  
  <div class="col-md-4 col-xl-4 py-4 bg-white text-dark rounded-4 p-5">
      <h2 class="mb-3">Lupa Kata Sandi</h2>

      <!-- <div id="emailSentAlert" class="alert alert-success" role="alert" style="display: none;">
      Kami telah mengirimkan email ke <span id="emailSpan"></span> dengan tautan untuk mengatur ulang kata sandi Anda.
      </div> -->

      <form id="recoveryForm" action="{{ route('recovery.post') }}" method="POST">
        @csrf

        <div class="mb-3">
          <input 
            type="email" 
            id="email" 
            name="email" 
            placeholder="Alamat email" 
            value="{{ old('email') }}" 
            class="form-control @error('email') is-invalid @enderror"
          >
          @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary mb-2 w-100 btn-finbites-hover">Kirim</button>
        <p class="S1 fs-6 mb-2">Kirim email untuk pengaturan ulang kata sandi.</p>
      </form>
    </div>
  </div>
</div>

<script src="/js/auth.js"></script>

@endsection
