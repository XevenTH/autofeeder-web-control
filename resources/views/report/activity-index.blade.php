@extends('layout.layout')

@section('content')

  <div class="container mt-3">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Data Aktivitas</li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="py-4 d-flex justify-content-between align-items-center">
          <h2>Tabel Data Aktivitas</h2>
          <a href="{{ route('report.activity.export') }}" class="btn btn-finbites-highlight">
            Expor Data
          </a>
        </div>
        <!-- @if(session()->has('pesan'))
        <div class="alert alert-success">
          {{ session()->get('pesan')}}
        </div>
        @endif -->
        <table class="table table-striped">
          <thead>
            <tr class="highlight">
              <!-- <th>#</th> -->
              <th class="d-finbites-sm-none">Id</th>
              <th class="d-finbites-sm-none">Log</th>
              <th class="d-finbites-sm-none">Tanggal Waktu</th>
              <th class="d-finbites-sm-none d-finbites-md-none">Subjek</th>
              <th>Deskripsi</th>
              <th class="d-finbites-sm-none d-finbites-md-none">Aktivitas</th>
              <th>Pengguna</th>
              <!-- <th class="d-finbites-sm-none">Sebelum</th>
              <th class="d-finbites-sm-none">Sesudah</th> -->
              <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($activities as $activity)
            <tr>
              <!-- <th>{{$loop->iteration}}</th> -->
              <td class="d-finbites-sm-none">{{$activity->id}}</td>
              <td class="d-finbites-sm-none">{{$activity->log_name}}</td>
              <td class="d-finbites-sm-none">{{$activity->created_at}}</td>
              <td class="d-finbites-sm-none d-finbites-md-none">{{$activity->subject_type}}</td>
              <td>{{$activity->description}}</td>
              <td class="d-finbites-sm-none d-finbites-md-none">{{$activity->event}}</td>
              <!-- <td>{{$activity->causer_id}}</td> -->
              <td>{{$activity->causer_name}}</td>
              <!-- <td class="d-finbites-sm-none">{{$activity->old}}</td>
              <td class="d-finbites-sm-none">{{$activity->attributes}}</td> -->
              <td>

                <div class="d-flex">
                  <div class="pe-3">
                  <!-- <a href="{{ route('report.activity.detail', ['activity' => $activity->id]) }}" class="btn btn-finbites-edit"><i class="lni lni-pencil"></i></a> -->
                    <!-- <a href="#" class="btn btn-finbites-edit" style="font-weight: bold;">...</a> -->
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-finbites-edit" style="font-weight: bold;" data-bs-toggle="modal" data-bs-target="{{ '#detailModal'.$activity->id }}">
                      ...
                    </button>
                  </div>
                </div>
                
              </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="{{ 'detailModal'.$activity->id }}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detailModalLabel">Rincian Aktivitas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <!-- {{json_encode($activity)}} -->
                    @forelse ($activity->toArray() as $a_key => $a_data)
                    <div class="row border-bottom">
                      <span class="col" style="max-width: 200px; font-weight: bold;">{{$a_key}}</span>
                      @if(is_array($a_data))
                      <span class="col">

                        <!-- {{ json_encode($a_data) }} -->
                        @forelse ($a_data as $b_key => $b_data)
                          @if(is_array($b_data) || $b_key == array_key_last($a_data))
                            <div class="row">
                          @else
                            <div class="row border-bottom">
                          @endif
                          <span class="col" style="max-width: 200px; font-weight: bold;">{{$b_key}}</span>
                          @if(is_array($b_data))
                          <span class="col">

                            <!-- {{ json_encode($b_data) }} -->      
                            @forelse ($b_data as $c_key => $c_data)
                              @if(is_array($c_data) || $c_key == array_key_last($b_data))
                                <div class="row">
                              @else
                                <div class="row border-bottom">
                              @endif
                              <span class="col" style="max-width: 200px; font-weight: bold;">{{$c_key}}</span>
                              @if(is_array($c_data))
                              <span class="col">

                                <!-- {{ json_encode($c_data) }} -->                                        

                              </span>
                              @else
                              <span class="col">
                                : {{ $c_data }}
                              </span>
                              @endif
                            </div>
                            @empty
                            <div class="col">
                              <span>Tidak ada data ...</span>
                            </div>
                            @endforelse
                              

                          </span>
                          @else
                          <span class="col">
                            : {{ $b_data }}
                          </span>
                          @endif
                        </div>
                        @empty
                        <div class="col">
                          <span>Tidak ada data ...</span>
                        </div>
                        @endforelse
                           

                      </span>
                      @else
                      <span class="col">
                        : {{ $a_data }}
                      </span>
                      @endif
                    </div>
                    @empty
                    <div class="col">
                      <span>Tidak ada data ...</span>
                    </div>
                    @endforelse
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                  </div>
                </div>
              </div>
            </div>

            @empty
            <td colspan="8" class="text-center">Tidak ada data...</td>
            @endforelse
          </tbody>
        </table>
        <nav class="container-fluid d-flex justify-content-center">
          {{ $activities->links() }}
        </nav>
      </div>

    </div>
  </div>



@endsection