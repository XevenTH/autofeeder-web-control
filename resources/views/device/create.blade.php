<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <title>Pendaftaran User</title>
</head>

<body>
  <div class="container mt-3">
  <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('devices.index') }}">Device</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
          </ol>
        </nav>
      </div>
    </div>    
    <div class="row">
      <div class="col-md-8 col-xl-6 py-4">
        <h2>Penambahan Device</h2>
        <hr>
        <form action="{{ route('devices.store') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label class="form-label" for="user_id">Id User</label>
            <select class="form-select" name="user_id" id="user_id" value="{{ old('user_id') }}">
            @forelse ($users as $user)
              <option value="{{$user->id}}" {{ old('user_id') == $user->id ? 'selected': '' }}>
                {{$user->id}} - {{$user->name}}
              </option>
            @empty
              <option disabled> none </option>
            @endforelse
            </select>

            @error('user_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label" for="name">Nama</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label" for="topic">Topik</label>
            <input type="text" id="topic" name="topic" value="{{ old('topic') }}" class="form-control @error('topic') is-invalid @enderror">
            @error('topic')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label" for="capacity">Kapasitas</label>
            <input type="text" id="capacity" name="capacity" value="{{ old('capacity') }}" class="form-control @error('capacity') is-invalid @enderror">
            @error('capacity')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary mb-2">Tambah</button>
        </form>
      </div>
    </div>
  </div>
</body>

</html>