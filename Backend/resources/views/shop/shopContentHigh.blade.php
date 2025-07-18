
@extends('shop.shopHigh')

@section('high')
<div class="shop-container container">
    <h1 class="shop-title">Organi shop</h1>


    <section id="menu" class="menu section-bg">
        <div class="container" data-aos="fade-up">
            <div class="row" data-aos="fade-up" data-aos-delay="100">
                @guest
                        <div class="col-lg-12 d-flex justify-content-center">
                            <ul id="menu-flters">
                                <li><a href="{{ url('shop') }}">All</a></li>
                                <li><a href="{{ url('shopLow') }}">Low Calorie</a></li>
                                <li><a href="{{ url('shopHigh') }}">High Calorie</a></li>

                            </ul>
                        </div>
                    @else
                        <div class="col-lg-12 d-flex justify-content-center">
                            <ul id="menu-flters">
                                <li><a href="{{ url('shop') }}">All</a></li>
                                <li><a href="{{ url('shopLow') }}">Low Calorie</a></li>
                                <li><a href="{{ url('shopHigh') }}">High Calorie</a></li>
                                <li><a href="{{ url('shopPlan') }}">My Plan</a></li>
                                {{-- <li data-filter=".filter-specialty">Specialty</li> --}}
                            </ul>
                        </div>
                    @endguest
            </div>
        </div>
    </section>
<div class="card-row row row-cols-1 row-cols-lg-3 row-cols-md-2 row-cols-sm-1">
    @foreach ($products as $item)
    @if ($item->category == 'h')
    <div class="card-col col mb-4">
        <div class="card-shape card h-100">
            <img src="{{ $item->product_img }}" class="card-img-top" style="border-radius: 100%; padding:20px;" alt="...">
            <div class="card-body">
                <a href="{{url('addtowishlist')}}/{{ $item->id }}" class="card-heart-btn btn btn-outline-success"><i class="far fa-heart"></i><span
                        class="heart-text">Add to whishlist</span></a>
                <h4 class="card-title">{{ $item->product_name }}</h4>
                <p class="card-text">{{ $item->description }}</p>
                <h2 class="price">{{ $item->price }} $</h2>
                <a href="{{url('addtocart')}}/{{ $item->id }}" class="card-btn btn btn-outline-success">Order now</a>
            </div>
        </div>
    </div>
    @endif

    @endforeach
</div>
</div>

@endsection
