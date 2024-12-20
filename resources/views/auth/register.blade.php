@extends('layouts.auth')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- First Name -->
                    <div class="form-floating mb-3">
                        <input class="form-control @error('name') is-invalid @enderror"
                               id="inputFirstName"
                               type="text"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="Enter your name"
                               required autofocus />
                        <label for="inputFirstName">Full Name</label>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="form-floating mb-3">
                        <input class="form-control @error('email') is-invalid @enderror"
                               id="inputEmail"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="name@example.com"
                               required />
                        <label for="inputEmail">Email Address</label>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control @error('password') is-invalid @enderror"
                                       id="inputPassword"
                                       type="password"
                                       name="password"
                                       placeholder="Create a password"
                                       required />
                                <label for="inputPassword">Password</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input class="form-control"
                                       id="inputPasswordConfirm"
                                       type="password"
                                       name="password_confirmation"
                                       placeholder="Confirm password"
                                       required />
                                <label for="inputPasswordConfirm">Confirm Password</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 mb-0">
                        <button type="submit" class="btn btn-primary btn-block">Create Account</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <div class="small"><a href="{{ route('login') }}">Have an account? Go to login</a></div>
            </div>
        </div>
    </div>
</div>
@endsection
