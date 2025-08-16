<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Logistics Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Asap&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('admin/login/login.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="d-flex justify-content-center align-items-center vh-100 logistics-bg">
  <div class="login-card shadow-lg p-4 rounded-4 bg-white animate__animated animate__fadeInDown">
    <div class="text-center mb-4">
      <i class="fas fa-truck-loading fa-3x text-primary"></i>
      <h3 class="mt-2">Logistics Portal</h3>
    </div>
    <form action="{{ route('auth.login') }}" method="post">
        @csrf
      <div class="input-group mb-3">
        <span class="input-group-text bg-light"><i class="fas fa-envelope text-primary"></i></span>
        <input type="text" class="form-control" placeholder="Email" name="email" required>
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text bg-light"><i class="fas fa-lock text-primary"></i></span>
        <input type="password" class="form-control" placeholder="Password" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary w-100 fw-bold">Sign In</button>
      <div class="text-end mt-2">
        <a href="#" class="text-muted small">Forgot password?</a>
      </div>
    </form>
  </div>

  <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('admin/plugins/toastr/toastr.min.js') }}"></script>
  <script>
    @if(session('success'))
        toastr.info("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>
</body>
</html>
