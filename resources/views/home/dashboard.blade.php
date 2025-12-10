@extends('layout.layout')

@section('content')

    <div class="container mt-3">

        <div class="row pt-4 text-center">
            <h2>Selamat datang di FinBites!</h2>
            <h6>Situs pemantauan dan pengaturan autofeeder.</h6>
            <hr>
        </div>

        <div class="row">
            <div class="col-12 col-md-4">
                <a href="{{ route('devices.simple') }}">
                    <div class="card border-0">
                        <div class="card-body py-4 d-flex justify-content-between">
                            <span class="fw-bold fs-5">
                                Jumlah Perangkat
                            </span>
                            <span class="badge fb-text-bg-primary me-2 fs-5 py-auto">
                                {{ count($devices) }}
                            </span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-4">
                <a href="{{ route('schedules.simple') }}">
                    <div class="card border-0">
                        <div class="card-body py-4 d-flex justify-content-between">
                            <span class="fw-bold fs-5">
                                Jadwal Terdaftar
                            </span>
                            <span class="badge fb-text-bg-primary me-2 fs-5 py-auto">
                                {{ count($schedules) }}
                            </span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-4">
                <a href="{{ route('schedules.simple') }}">
                    <div class="card border-0">
                        <div class="card-body py-4 d-flex justify-content-between">
                            <span class="fw-bold fs-5">
                                Jadwal Aktif
                            </span>
                            <span class="badge fb-text-bg-primary me-2 fs-5 py-auto">
                                {{ count($active_schedules) }}
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">

            <div class="col-12 col-md-6">
                <a href="{{ route('schedules.simple') }}">
                    <div class="card border-0 fb-bg-gradient">
                        <div class="card-body py-4 d-flex justify-content-center">
                            @include('home.clock')
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6">

                <table class="table table-striped mt-3">
                    <thead>
                        <tr class="highlight">
                            <th>#</th>
                            <th>Perangkat</th>
                            <th class="d-finbites-sm-none">Hari</th>
                            <th>Jam</th>
                            <th class="d-finbites-sm-none">Status</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($active_schedules as $schedule)
                            <tr>
                                <th>{{ $loop->iteration }}</th>

                                <td class="d-finbites-sm-none">{{ $schedule->name }}</td>
                                <!-- untuk tampilan mobile -->
                                <td class="d-finbites-sm-table-cell">{{ Str::limit($schedule->name, 9) }}</td>

                                <td class="d-finbites-sm-none">
                                    @forelse (explode(' ', $schedule->days) as $day)
                                        @if ($day == '-')
                                            <span class="badge text-bg-warning rounded-pill">Kiamat</span>
                                        @elseif ($day == 'Monday')
                                            <span class="badge fb-text-bg-primary rounded-pill">Senin</span>
                                        @elseif ($day == 'Tuesday')
                                            <span class="badge fb-text-bg-primary rounded-pill">Selasa</span>
                                        @elseif ($day == 'Wednesday')
                                            <span class="badge fb-text-bg-primary rounded-pill">Rabu</span>
                                        @elseif ($day == 'Thursday')
                                            <span class="badge fb-text-bg-primary rounded-pill">Kamis</span>
                                        @elseif ($day == 'Friday')
                                            <span class="badge fb-text-bg-primary rounded-pill">Jumat</span>
                                        @elseif ($day == 'Saturday')
                                            <span class="badge fb-text-bg-primary rounded-pill">Sabtu</span>
                                        @elseif ($day == 'Sunday')
                                            <span class="badge fb-text-bg-primary rounded-pill">Minggu</span>
                                        @endif

                                    @empty
                                    @endforelse
                                </td>
                                <td>{{ Str::substr($schedule->time, 0, 5) }}</td>
                                <td class="d-finbites-sm-none">
                                    @if ($schedule->active == 1)
                                        <span class="badge text-bg-success rounded-pill">AKTIF</span>
                                    @else
                                        <span class="badge text-bg-secondary rounded-pill">TIDAK<br>AKTIF</span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <a href="{{ route('schedules.simple.edit', ['schedule' => $schedule->id]) }}"
                                            class="btn btn-finbites-edit"><i class="lni lni-pencil"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <td colspan="8" class="text-center">Tidak ada jadwal yang dibuat...</td>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <div class="row">

            @forelse ($devices as $device)
                <div
                    class="@if (count($devices) < 2) col-12
                @elseif (count($devices) == 2)
                col-12 col-md-6
                @elseif (count($devices) > 2)
                col-12 col-md-4 @endif
                ">
                    <a href="{{ route('devices.simple.edit', ['device' => $device->id]) }}">
                        <div class="card border-0">
                            <div class="card-body py-4">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold fs-5">
                                        {{ Str::limit($device->name, 20) }}
                                    </span>

                                    <span class="fw-bold fs-5">
                                        {{ Str::substr(100 - (($device->capacity - 2) / 10) * 100, 0, 4) }}%
                                    </span>
                                </div>
                                <div class="progress w-100">
                                    <div id="progress-{{ $device->id }}"
                                        class="progress-bar progress-bar-striped progress-bar-animated
                           @if ($device->capacity >= 10) bg-danger 
                          @elseif ($device->capacity >= 9) 
                            bg-orange
                          @else
                            bg-success @endif"
                                        role="progressbar" aria-valuenow="{{ 100 - (($device->capacity - 2) / 10) * 100 }}"
                                        aria-valuemin="0" aria-valuemax="100"
                                        style="width: {{ 100 - (($device->capacity - 2) / 10) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <a href="{{ route('devices.simple') }}">
                        <div class="card border-0">
                            <div class="card-body py-4 d-flex justify-content-center">
                                <span class="fw-bold fs-5">
                                    Tidak Ada Perangkat Terdaftar!
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforelse

        </div>

    </div>

    <script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>
    <script>
        const client = mqtt.connect("wss://broker.emqx.io:8084/mqtt", {
            clientId: "laravel_client_" + Math.random().toString(16).substr(2, 8),
        });

        client.on("connect", function() {
            console.log("Terhubung ke broker");
            console.log(client);
            client.subscribe("laravel/demo", function(err) {
                if (!err) {
                    console.log("Berhasil subscribe ke laravel/demo");
                }
            });
        });

        client.on("message", function(topic, message) {
            try {
                const parsedMessage = JSON.parse(message.toString());
                const {
                    id_device,
                    data
                } = parsedMessage;

                const progressBar = document.getElementById(`progress-${id_device}`);
                if (progressBar && data.capacity !== undefined) {
                    const percentage = 100 - ((data.capacity - 2) / 10) * 100;

                    progressBar.style.width = percentage + "%";
                    progressBar.setAttribute("aria-valuenow", percentage);

                    progressBar.classList.remove("bg-danger", "bg-orange", "bg-success");

                    if (data.capacity >= 10) {
                        progressBar.classList.add("bg-danger");
                    } else if (data.capacity >= 9) {
                        progressBar.classList.add("bg-orange");
                    } else {
                        progressBar.classList.add("bg-success");
                    }
                }
            } catch (err) {
                console.error("Error parsing message:", err);
            }
        });
    </script>

@endsection
