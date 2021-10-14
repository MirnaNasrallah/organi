@extends('layout')

@section('content')
<div class="container">
    <div class="dash-container row justify-content-center">
        <div class="col-md-12">
            <div class="dash-card card">
                <div class="dash-card-header card-header"><h1 style="margin-top:20px" >Your Whishlist</h1></div>
                <hr>

                <div class="dash-card-body card-body">
                    @if (session('success'))
                        <div class="login-alert alert alert-success" role="alert">
                            {{ session('success') }}

                        </div>
                    @endif
                       @foreach ($products as $item)

                       <div class="card-col col mb-4" style="width:50%;">
                    <div class="card-shape card h-100">
                      <img src="{{ $item->product_img }}" style="width:30%; border-radius: 100%; margin-top:20px; margin-left:20px; margin-bottom:20px" class="card-img-top" alt="...">
                        <div class="card-body">
                        <h4 class="card-title" >{{ $item->product_name }}</h4>
                        <div class="d-flex">
                            <h3 class="price flex-fill">{{ $item->price }} $</h3>
                            <a id="button1" href="{{url('addtocart')}}/{{ $item->id }}" class="card-btn btn btn-outline-success">Order now</a>
                            <a id="button2" href="{{url('deletefromwishlist')}}/{{ $item->id }}" class="card-btn btn btn-outline-success">Delete</a>
                        </div>
                        </div>
                    </div>
                </div>
                       @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
