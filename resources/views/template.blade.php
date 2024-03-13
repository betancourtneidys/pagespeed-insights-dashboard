<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Challenge Broobe</title>
</head>
<body>
  <div class="text-center pt-5 pb-3 bg-secondary bg-gradient bg-opacity-25">
    <a class="navbar-brand" href="/">
      <img src="/logo-broobe.svg" alt="Bootstrap" width="200">
    </a>
    <h5>Challenge</h5>
  </div>
  <div class="container">
    <nav class="nav justify-content-center fs-5 my-5">
      <ul class="nav nav-underline grid column-gap-5">
        <li class="nav-item">
          <a class="nav-link text-reset fw-medium" href="/">Run Metric</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-reset fw-medium" href="/metric-history">Metric History</a>
        </li>
      </ul>
    </nav>
  </div>
  
  @yield('content')
</body>
</html>