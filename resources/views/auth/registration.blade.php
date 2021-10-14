@extends('layout')

@section('content')
    <div class="reg-container">
        <div class="form-container">
            <h1 class="reg-header">Register</h1>
            <hr class="line">
            <div class="reg-body">

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf

                    <label for="name" class="label">Name</label>
                    <input type="text" id="name" class="form-control input" name="name" required autofocus>
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif

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


                    <button type="submit" class="reg-form-btn btn btn-success">
                        Register
                    </button>

                </form>

            </div>
        </div>
    </div>
@endsection
