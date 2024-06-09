<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FinBites</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/custom.css">
</head>

<body>
  <!-- Navbar Top -->
  <nav class="navbar fixed-top bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="/img/logo-black.png" alt="Logo FinBite" width="50" class="d-inline-block align-text-top ms-5">
        <span class="ms-1">FinBites</span>
      </a>
    </div>
  </nav>

  <main class="content px-3 py-4 custom-content-middle">
    <div class="container">

      @yield('content')

    </div>

  </main>

  <script>
    const password = document.querySelector('#password');
    if (password) {
      document.getElementById('togglePassword').addEventListener('click', function() {
        // Mendapatkan tipe atribut
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // Men-toggle kelas icon
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
      })
    }
    
    const passwordConf = document.querySelector('#password_confirmation');
    if (passwordConf) {
      document.getElementById('togglePasswordConfirmation').addEventListener('click', function() {
        // Mendapatkan tipe atribut
        const type = passwordConf.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConf.setAttribute('type', type);

        // Men-toggle kelas icon
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
      })
    }
  </script>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @include('sweetalert::alert')

</body>

</html>