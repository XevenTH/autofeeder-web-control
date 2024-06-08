<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/custom.css" />
  <link rel="stylesheet" href="/css/style.css" />
  <title>Recovery</title>
</head>

<body>
<nav class="navbar bg-body-tertiary bg-white" data-bs-theme="white">
  <div class="container-fluid">
    <a class="navbar-brand align-self-start" href="#">
      <img src="/img/logo-putih@2x.png" alt="Bootstrap" width="30" height="20" class="me-2">
      <span>FinBite</span>
    </a>
  </div>
</nav>

<div class="container mt-3" id="custom-container">
  <div class="row d-flex align-items-center p-5" style="position:absolute; top: 25vh">
    <div class="col-md-8 col-xl-8 py-4">
      <p class="fs-4 fw-bold">FinBite: Auto Feeder Monitoring</p>
      <p>FinBites memastikan ikan Anda mendapatkan makanan tepat waktu, bahkan ketika kita sibuk. Jadwal yang terprogram dan kontrol porsi membuat teman-teman Anda tetap sehat dan bahagia, apa pun yang terjadi."</p>
    </div>
    <div class="col-md-4 col-xl-4 py-4 bg-white text-dark rounded-4 p-5">
      <h2 class="mb-4">Lupa password?</h2>
      @if(Session::has('pesan'))
        <div class="alert alert-primary" role="alert">
          {{ Session::get('pesan') }}
        </div>
      @endif
    
      <form action="{{ route('recovery.post') }}" method="POST">
          @csrf

      <div id="emailSentAlert" class="alert alert-success" role="alert" style="display: none;">
      Kami telah mengirimkan email ke <span id="emailSpan"></span> dengan tautan untuk mengatur ulang kata sandi Anda.
      </div>

      <form id="recoveryForm" action="{{ route('recovery') }}" method="POST">
        @csrf

        <div class="mb-3">
          <!-- <label class="form-label" for="email">Email</label> -->
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

        <button type="submit" class="btn btn-primary mb-2 w-100 btn-finbites-hover">Lanjut</button>
      </form>
    </div>
  </div>
</div>

<script src="/js/auth.js"></script>
</body>

</html>
