<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/register.css">
  <title>Register</title>
</head>

<body>
  <!-- Navbar Top -->
  <nav class="navbar fixed-top bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="/img/logo-black.png" alt="Logo FinBite" width="50" class="d-inline-block align-text-top ms-5">
        FinBite
      </a>
    </div>
  </nav>
  <!-- Register -->
  <section id="register">
    <div class="container-fluid overlay h-100">
      <div class="row">
        <div class="text-body col-md-7">
          <h3 class="mx-5">FinBite: Auto Feeder Montioring</h3>
          <p class="mx-5">FinBites ensures your fish get their meals on time, even when life gets busy. Programmed schedules and portion control keep your fin-tastic friends healthy and happy, no matter what."</p>
        </div>
        <div class="col-md-4 form-box">
          <div class="card-register w-100">
            <form>
              <h2>Register</h2>
              @if(Session::has('pesan'))
              <div class="alert alert-primary" role="alert">
                {{ Session::get('pesan') }}
              </div>
              @endif
              <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                  <input type="name" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Pengguna">
                  @error('name')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Alamat Email">
                  @error('email')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <input type="phone" id="phone" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="No. Telp (081234567890)">
                  @error('phone')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <input type="password" id="password" name="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                  @error('password')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-5">
                  <input type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Konfirmasi Password">
                  @error('password_confirmation')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <button type="submit" class="button-daftar btn-primary mb-3">Daftar</button>
                <p>Sudah punya akun? <span class>Masuk</span></p>
          </div>
          </form>
        </div>
      </div>
    </div>
    </div>
  </section>
  <!-- <nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
      <img src="img/logo-black.png" alt="logo FinBite"  width = "50" style="transform: translateX(-10px);"> FinBite
      </a>
    </div>
  </nav>
  <div class="container mt-3" style = "background-image: img src=">
    <div class="row">
      <div class="col-md-8 col-xl-6 py-4">
        <h2>Register</h2>
        <hr>
        @if(Session::has('pesan'))
          <div class="alert alert-primary" role="alert">
          {{ Session::get('pesan') }}
          </div>
        @endif
        <form action="{{ route('register.post') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label class="form-label" for="email">Name</label>
            <input type="name" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="mb-3">
            <label class="form-label" for="phone">No. Telp</label>
            <input type="phone" id="phone" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="08123456789">
            @error('phone')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" name="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror">
            @error('password')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="mb-3">
            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control @error('password_confirmation') is-invalid @enderror">
            @error('password_confirmation')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary mb-2">Daftar</button>
        </form>
      </div>
    </div>
  </div> -->
</body>

</html>