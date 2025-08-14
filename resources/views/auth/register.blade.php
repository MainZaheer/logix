<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Logistics | Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition register-page">
<div class="register-box">

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new User</p>

      <form action="{{ route('auth.register') }}" method="post">
        @csrf
        
        
         {{-- Business Name --}}
  <div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Business Name" name="business_name" required>
    @error('business_name') <span class="text-danger">{{ $message }}</span> @enderror
    <div class="input-group-append">
      <div class="input-group-text"><i class="fas fa-briefcase"></i></div>
    </div>
  </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Full name" name="name" required>
          @error('name')
          <span class="text-danger">{{ $message }}</span>
          @enderror
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" required>
            @error('email')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" required>
            @error('password')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Confirm password" name="password_confirmation" required>
            @error('password_confirmation')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        
        
         {{-- City --}}
  <div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="City" name="city" >
    @error('city') <span class="text-danger">{{ $message }}</span> @enderror
    <div class="input-group-append">
      <div class="input-group-text"><i class="fas fa-city"></i></div>
    </div>
  </div>


{{-- State --}}
  <div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="State" name="state" >
    @error('state') <span class="text-danger">{{ $message }}</span> @enderror
    <div class="input-group-append">
      <div class="input-group-text"><i class="fas fa-map-marker-alt"></i></div>
    </div>
  </div>

  {{-- Country --}}
  <div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Country" name="country" >
    @error('country') <span class="text-danger">{{ $message }}</span> @enderror
    <div class="input-group-append">
      <div class="input-group-text"><i class="fas fa-flag"></i></div>
    </div>
  </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('admin/dist/js/adminlte.min.js') }}"></script>




</body>
</html>
