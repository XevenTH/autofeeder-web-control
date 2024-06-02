<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <title>Detail Data {{$user->nama}}</title>
</head>

<body>
  <div class="container mt-3">
    <div class="row">
      <div class="col-12">
        <div class="pt-3 d-flex justify-content-between align-items-center">
          <h2>Detail Data {{$user->nama}}</h2>
          <div class="d-flex">
            <a href="{{ route('users.edit',['user' => $user->id]) }}" class="btn btn-primary">Edit</a>
            <form method="POST" action="{{ route('users.destroy', ['user' => $user->id]) }}">
              @method('DELETE')
              @csrf
              <button type="submit" class="btn btn-danger ms-3">Hapus</button>
            </form>
          </div>
        </div>
        <hr>
        @if(session()->has('pesan'))
        <div class="alert alert-success" role="alert">
          {{ session()->get('pesan')}}
        </div>
        @endif
        <ul>
          <li>Nama: {{$user->name}} </li>
          <li>Email: {{$user->email}} </li>
          <li>Password: {{$user->password}} </li>
        </ul>
      </div>
    </div>
  </div>
</body>

</html>