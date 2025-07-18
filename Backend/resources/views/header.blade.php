<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-cente">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-lg-between">

        <h1 class="logo me-auto me-lg-0"><a href="/">Organi</a></h1>
        <nav id="navbar" class="navbar order-last order-lg-0">
            @guest
            <ul>
                <li><a class="nav-link scrollto" href="/">Home</a></li>
                <li><a class="nav-link scrollto" href="/">Calories Calculator</a></li>
                <li><a class="nav-link scrollto" href="/">Shop</a></li>
            </ul>
            @else
            <ul>
                <li><a class="nav-link scrollto" href="/">Home</a></li>
                <li><a class="nav-link scrollto" href="/">Calories Calculator</a></li>
                <li><a class="nav-link scrollto" href="/">Shop</a></li>
                <li><a class="nav-link scrollto" href="/">Wishlist</a></li>
                <li><a class="nav-link scrollto" href="/">Cart</a></li>
            </ul>
            @endguest
        </nav><!-- .navbar -->
        <div class="search">
            <form action="/" method="GET"
                class="form-inline d-flex justify-content-center md-form form-sm active-cyan-2">
                <input class="form-control form-control-sm mr-3 w-75" type="text" placeholder="Search Products"
                    aria-label="Search" name="search-input">
                <i class="fas fa-search" aria-hidden="true"></i>
            </form>
        </div>
        <div>
            @guest
                <a class="login-btn btn btn-outline-light"  href="/">Login</a>
                <a class="register-btn btn btn-outline-light" href="/">Register</a>
            @else
                <a class="logout-btn btn btn-outline-light" href="/">Logout</a>
            @endguest
        </div>
        <i class="bi bi-list mobile-nav-toggle"></i>
    </div>
</header><!-- End Header -->
