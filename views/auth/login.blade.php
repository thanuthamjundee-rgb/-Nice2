@extends('layouts.master-without-nav')
@section('title')
    @lang('translation.Login')
@endsection
<link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@section('content')
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
           
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">เข้าสู่ระบบผู้ใช้งาน !</h5>
                                <p class="text-muted">Sign in to continue.</p>
                            </div>
                            @if(session('fail'))
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: '{{ session('fail') }}',
                                        confirmButtonText: 'OK'
                                    });
                                </script>
                            @endif
                            <div class="p-2 mt-4">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                            name="email" id="email"
                                            placeholder="Enter Email address">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <div class="float-end">
                                        </div>
                                        <label class="form-label" for="userpassword">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            name="password" id="userpassword" placeholder="Enter password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="auth-remember-check"
                                            name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                    </div>

                                    <div class="mt-3 text-end">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">เข้าสู่ระบบ</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                    <div class="mt-5 text-center">
                    
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>

@endsection
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
