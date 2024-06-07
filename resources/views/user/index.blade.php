@extends('layout.layout')

@section('content')

  <div class="container mt-3">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Data Pengguna</li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="py-4 d-flex justify-content-between align-items-center">
          <h2>Tabel Data Pengguna</h2>
          <a href="{{ route('users.create') }}" class="btn btn-finbites-highlight">
            Tambah Pengguna
          </a>
        </div>
        @if(session()->has('pesan'))
        <div class="alert alert-success">
          {{ session()->get('pesan')}}
        </div>
        @endif
        <table class="table table-striped">
          <thead>
            <tr class="highlight">
              <th>#</th>
              <th>Nama</th>
              <th>Email</th>
              <th class="d-finbites-sm-none">No. Telp</th>
              <th class="d-finbites-sm-none">Password</th>
              <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $user)
            <tr>
              <th>{{$loop->iteration}}</th>
              
              <td class="d-finbites-sm-none">{{$user->name}}</td>
              <td class="d-finbites-sm-none">{{$user->email}}</td>
              <!-- untuk tampilan mobile -->
              <td class="d-finbites-sm-table-cell">{{Str::limit($user->name, 5)}}</td>
              <td class="d-finbites-sm-table-cell">{{Str::limit($user->email, 5)}}</td>

              <td class="d-finbites-sm-none">{{$user->phone}}</td>
              <td class="d-finbites-sm-none">{{Str::limit($user->password, 20)}}</td>

              <td>
                
                <div class="d-flex">
                  <div class="pe-3">
                    <a href="{{ route('users.edit',['user' => $user->id]) }}" class="btn btn-finbites-edit"><i class="lni lni-pencil"></i></a>
                  </div>
                  <div>
                    <a href="{{ route('users.destroy', ['user' => $user->id]) }}" class="btn btn-finbites-delete" data-confirm-delete="true"><i class="lni lni-trash-can"></i></a>
                  </div>
                </div>

              </td>
            </tr>
            @empty
            <td colspan="6" class="text-center">Tidak ada data...</td>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection