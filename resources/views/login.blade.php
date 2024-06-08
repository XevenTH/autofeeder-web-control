<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <title>Login</title>
</head>

<body>
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-8 col-xl-6 py-4">
        <h2>Login</h2>
        <hr>
        @if(Session::has('pesan'))
          <div class="alert alert-primary" role="alert">
          {{ Session::get('pesan') }}
          </div>
        @endif
        <form action="{{ route('login') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
            @error('email')
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

          <button type="submit" class="btn btn-primary mb-2">Masuk</button>
        </form>
        <a href="{{ route('register') }}">Daftar</a>
      </div>
    </div>
  </div>
  @include('sweetalert::alert')
</body>

</html>