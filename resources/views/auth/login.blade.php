@extends('template.auth.auth')

@section('title','Login')

@section('content')

    <p class="login-box-msg">Sign in to start your session</p>

    <form method="POST" action="{{ route('login.post') }}">
    @csrf

    <!-- Email -->
    <div class="input-group mb-3">
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
               class="form-control @error('email') is-invalid @enderror" placeholder="Email">
        <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
        </div>
        @error('email')
            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <!-- Password -->
    <div class="input-group mb-3">
        <input id="password" type="password" name="password" required
               class="form-control @error('password') is-invalid @enderror" placeholder="Password">
        <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
        </div>
        @error('password')
            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="row">
        <!-- <div class="col-8">
            <div class="icheck-primary">
                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Remember Me</label>
            </div>
        </div> -->
        <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </div>
    </div>
</form>
@endsection