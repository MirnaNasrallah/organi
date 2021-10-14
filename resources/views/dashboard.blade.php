@extends('layout')

@section('content')
    <div class="container">
        <div class="dash-container row justify-content-center">
            <div class="col-md-12">
                <div class="dash-card card">
                    <div class="dash-card-header card-header">
                        <h1 style="margin-top:20px">Your Calories Calculator</h1>
                    </div>
                    <hr>

                    <div class="bmi-profile dash-cards-body card-body">
                        <form action="{{ route('user.update') }}" method="POST">
                            @csrf
                            <input class="bmi-input" type="text" class="form-control input" name="weight"
                                placeholder="weight">
                            <input class="bmi-input" type="text" class="form-control input" name="height"
                                placeholder="height">
                            <input class="bmi-input" type="text" class="form-control input" name="age" placeholder="age">
                            <input class="bmi-input gender" type="text" class="form-control input" name="gender"
                                placeholder="gender">
                            <input class="bmi-input" type="text" class="form-control input" name="AddedCal"
                                placeholder="Calories">
                            <button class="bmi-button" type="submit" class="reg-form-btn btn btn-success">
                                Results
                            </button>
                        </form>

                        @if (session('success'))
                        <div class="callout" data-aos="fade-up" data-aos-delay="100" >
                            <div class="callout-header">Your Results</div>

                            <div class="callout-container">
                            {{ session('success') }}

                            </div>
                        </div>
                       @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
