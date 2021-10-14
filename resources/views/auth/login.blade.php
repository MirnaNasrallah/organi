@extends('layout')

@section('content')
    <div class="login-container">
        <div class="form-container">
            <h1 class="login-header">Login</h1>
            <hr class="line">
            <div class="login-body">

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    <label for="email_address" class="label">E-Mail Address</label>
                    <input type="text" id="email_address" class="form-control input" name="email" required autofocus>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif

                    <label for="password" class="label">Password</label>
                    <input type="password" id="password" class="form-control input" name="password" required>
                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                    </div>


                    <button type="submit" class="login-form-btn btn btn-success" >Login</button>

                    @if (session('success'))
                        <div class="reg-alert alert alert-success" role="alert">
                            {{ session('success') }}
                            
                        </div>
                    @endif
                </form>

            </div>
        </div>
    </div>
@endsection
