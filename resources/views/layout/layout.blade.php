<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FinBites</title>
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/style.css">  
</head>

<body>
  <div class="wrapper">
    <aside id="sidebar">
      <div class="d-flex">
        <button class="toggle-btn" type="button">
          <!-- <i class="lni lni-grid-alt"></i> -->
          <img src="/img/logo-white.png" alt="logo FinBite" width="40" style="transform: translateX(-10px);">
        </button>
        <div class="sidebar-logo">
          <a href="#">FinBites</a>
        </div>
      </div>
      <ul class="sidebar-nav">
        <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="lni lni-home"></i>
            <span>Dasbor</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="lni lni-dashboard"></i>
            <span>Perangkat</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="lni lni-alarm-clock"></i>
            <span>Jadwal</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
            <i class="lni lni-protection"></i>
            <span>Admin</span>
          </a>
          <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item">
              <a href="{{ route('users.index') }}" class="sidebar-link">Data Pengguna</a>
            </li>
            <li class="sidebar-item">
              <a href="{{ route('devices.index') }}" class="sidebar-link">Data Perangkat</a>
            </li>
            <li class="sidebar-item">
              <a href="{{ route('schedules.index') }}" class="sidebar-link">Data Jadwal</a>
            </li>
          </ul>
        </li>
        <!-- <li class="sidebar-item">
          <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
            <i class="lni lni-layout"></i>
            <span>Multi Level</span>
          </a>
          <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item">
              <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">
                Two Links
              </a>
              <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
                <li class="sidebar-item">
                  <a href="#" class="sidebar-link">Link 1</a>
                </li>
                <li class="sidebar-item">
                  <a href="#" class="sidebar-link">Link 2</a>
                </li>
              </ul>
            </li>
          </ul>
        </li> -->
        <!-- <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="lni lni-popup"></i>
            <span>Notification</span>
          </a>
        </li> -->
        <!-- <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="lni lni-cog"></i>
            <span>Setting</span>
          </a>
        </li> -->
      </ul>
      <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST" class="d-flex" role="search" id="sidebar-logout">
          @csrf
          @method('DELETE')
        </form>
        <a href="#" class="sidebar-link" onclick="document.getElementById('sidebar-logout').submit()">
          <i class="lni lni-exit"></i>
          <span>Logout</span>
        </a>
        <!-- <a href="#" class="sidebar-link">
          <i class="lni lni-exit"></i>
          <span>Logout</span>
        </a> -->
      </div>
    </aside>
    <div class="main">
      <nav class="navbar navbar-expand px-4 py-3">
        <!-- <form action="#" class="d-none d-sm-inline-block">
          <div class="input-group input-group-navbar">
            <input type="text" class="form-control border-0 rounded-0" placeholder="Search...">
            <button class="btn border-0 rounded-0" type="button">
              Search
            </button>
          </div>
        </form> -->
        <div class="navbar-collapse collapse">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
              <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                <img src="/img/profil.jpg" class="avatar img-fluid" alt="">
              </a>
              <div class="dropdown-menu dropdown-menu-end rounded">
                <a href="#" class="dropdown-item">
                  <i class="lni lni-user"></i>
                  <span>Edit Profil</span>
                </a>
                <!-- <a href="#" class="dropdown-item">
                  <i class="lni lni-cog"></i>
                  <span>Settings</span>
                </a> -->
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" onclick="document.getElementById('sidebar-logout').submit()">
                  <i class="lni lni-exit"></i>
                  <span>Logout</span>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </nav>
      <main class="content px-3 py-4">
        <div class="container-fluid">
          <div class="mb-3">

            {{-- Page content goes here --}}
            @yield('content')

          </div>
        </div>
      </main>

      <footer class="footer">
        <div class="container-fluid">
          <div class="row text-body-secondary">
            <div class="col-6 text-start ">
              <a class="text-body-secondary" href=" #">
                <strong>FinBites</strong>
              </a>
            </div>
            <div class="col-6 text-end text-body-secondary d-none d-md-block">
              <ul class="list-inline mb-0">
                <li class="list-inline-item">
                  <a class="text-body-secondary" href="#">Kontak</a>
                </li>
                <li class="list-inline-item">
                  <a class="text-body-secondary" href="#">Tentang Kami</a>
                </li>
                <li class="list-inline-item">
                  <a class="text-body-secondary" href="#">Syarat & Kondisi</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>

    </div>
  </div>
  @include('sweetalert::alert')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="/js/script.js"></script>
</body>

</html>