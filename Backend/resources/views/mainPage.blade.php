<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <link href="https://i.pinimg.com/originals/6f/a1/09/6fa1097f0e5dbf443ded92eceaef2b5f.jpg" rel="icon">
    <link href="https://i.pinimg.com/originals/6f/a1/09/6fa1097f0e5dbf443ded92eceaef2b5f.jpg" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link
        href="{{ asset('https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i') }}"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/animate.css/animate.min.css') }}">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">

    <!-- Vendor JS Files -->
    <script src="{{ URL('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ URL('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ URL('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ URL('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ URL('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <script src="https://kit.fontawesome.com/3a0d673fb7.js" crossorigin="anonymous"></script>
    <!-- Template Main JS File -->
    <script src="{{ URL('assets/js/main.js') }}"></script>
    <title>Organi </title>
</head>

<body>
    {{ View::make('header') }}

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
        <div class="container position-relative text-center text-lg-start" data-aos="zoom-in" data-aos-delay="100">
            <div class="row">
                <div class="col-lg-8">
                    <h1>Welcome to <span>Organi</span></h1>
                    <h2>Your Ticket For A Better Lifestyle</h2>
                    <div class="btns">
                        <a href="/shop" class="btn-menu animated fadeInUp scrollto">Our Shop</a>
                        <a href="#specials" class="btn-book animated fadeInUp scrollto">BMI Calculator</a>
                    </div>
                </div>
                <div class="col-lg-4 d-flex align-items-center justify-content-center position-relative"
                    data-aos="zoom-in" data-aos-delay="200">
                    <a href="https://www.youtube.com/c/xhit" class="glightbox play-btn"></a>
                </div>
            </div>
        </div>
    </section><!-- End Hero -->

    <main id="main">
        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">

                <div class="row">
                    <div class="col-lg-6 order-1 order-lg-2" data-aos="zoom-in" data-aos-delay="100">
                        <div class="about-img">
                            <img src="https://images.squarespace-cdn.com/content/v1/5161a33ce4b058e82d881bb3/1392921734387-TZ98121OI0LVXTX8UI1G/image-asset.jpeg?format=1000w"
                                alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
                        <h3>Healthy is an outfit that looks different on everybody</h3>
                        <p class="fst-italic">
                            In Organi you'll not only experience an outstanding healthy food shop you'll get yourself
                            started on a new lifestyle
                        </p>
                        <ul>
                            <li><i class="bi bi-check-circle"></i> BMI Calculator</li>
                            <li><i class="bi bi-check-circle"></i> Fresh Food Shop</li>
                            <li><i class="bi bi-check-circle"></i> Excersises.</li>
                        </ul>
                        <p>
                            We're passionate about helping You finding your perfect diet options by shopping for foods
                            that are only stream_bucket_make_writeable
                            for you and your body type, this will guide you to not only that perfect body but into a
                            wonderful fresh life.
                        </p>
                    </div>
                </div>
            </div>
        </section><!-- End About Section -->

        <!-- ======= Why Us Section ======= -->
        <section id="why-us" class="why-us">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Why Us</h2>
                    <p>Why Choose Organi</p>
                </div>

                <div class="row">

                    <div class="col-lg-4">
                        <div class="box" data-aos="zoom-in" data-aos-delay="100">
                            <span>01</span>
                            <h4>Know Your Body Type</h4>
                            <p>Calculate Your BMI And know Your Body Type</p>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0">
                        <div class="box" data-aos="zoom-in" data-aos-delay="200">
                            <span>02</span>
                            <h4>Your Perfect Diet</h4>
                            <p>Explore The Healthy Food Options For Your Body Type</p>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0">
                        <div class="box" data-aos="zoom-in" data-aos-delay="300">
                            <span>03</span>
                            <h4> Be In Shape</h4>
                            <p>Find Your Most Suitable And Prefered Excersises</p>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Why Us Section -->


        <!-- ======= BMI Calculator ======= -->
        <section id="specials" class="specials">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Calculate Your BMI</h2>
                    <p>Calculate</p>
                </div>

                @guest
                <script>
                    function calc() {
                        var w = document.getElementById('weight').value;
                        document.getElementById('alert').innerHTML = 'Your BMI Is : ' + w;
                        var h = document.getElementById('height').value;
                        document.getElementById('alert').innerHTML = 'Your BMI Is : ' + h;
                        var cal = w / (h*h);
                        var category;
                        if(cal< 20)
                        {
                            category = "You are underweight";
                        }
                        else if (cal >= 20 && cal < 25)
                        {
                            category = "You're rockin a healthy body! "
                        }
                        else if (cal >=25 && cal < 30)
                        {
                            category = "You are overweight ";
                        }
                        else if(cal >= 30)
                        {
                            category = "You are obese";
                        }
                        document.getElementById('alert').innerHTML = 'Your BMI Is : '+cal.toFixed(2)+"  ,  "+category;
                        const btn = document.createElement('button');
                        btn.id = "plan";
                        btn.innerText='Get a plan';
                        btn.type = "button";
                        document.getElementById('abc').appendChild(btn);
                        btn.onclick = function()
                        {
                            location.href='{{ url('registration') }}';
                        }

                    }
                </script>

                @else
                <script>
                    function calc() {
                        var w = document.getElementById('weight').value;
                        document.getElementById('alert').innerHTML = 'Your BMI Is : ' + w;
                        var h = document.getElementById('height').value;
                        document.getElementById('alert').innerHTML = 'Your BMI Is : ' + h;
                        var cal = w / (h*h);
                        var category;
                        if(cal< 20)
                        {
                            category = "You are underweight";
                        }
                        else if (cal >= 20 && cal < 25)
                        {
                            category = "You're rockin a healthy body! "
                        }
                        else if (cal >=25 && cal < 30)
                        {
                            category = "You are overweight ";
                        }
                        else if(cal >= 30)
                        {
                            category = "You are obese";
                        }
                        document.getElementById('alert').innerHTML = 'Your BMI Is : '+cal.toFixed(2)+"  ,  "+category;
                        const btn = document.createElement('button');
                        btn.id = "plan";
                        btn.innerText='Get a plan';
                        btn.type = "button";
                        document.getElementById('abc').appendChild(btn);
                        btn.onclick = function()
                        {
                            location.href='{{ url('shop') }}';
                        }

                    }
                </script>
                @endguest


                <form data-aos="fade-up" data-aos-delay="100">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 form-group">
                            <input class="bmihome-input" type="text" id="weight" placeholder="Your Weight " value="">
                        </div>
                        <div class="col-lg-3 col-md-6 form-group">
                            <input class="bmihome-input"  type="text" id="height" placeholder="Your Height " value="">
                        </div>
                        <div class="col-lg-3 col-md-6 form-group">
                            <input class="bmihome-input" type="button" value="Calculate" onclick="calc()" />
                        </div>
                        <div class="mb-3">
                            <div id="alert"></div>
                        </div>
                        <div class="mb-3">
                            <div id="abc"></div>
                        </div>
                    </div>
                </form>
            </div>

        </section><!-- End Specials Section -->
    </main><!-- End #main -->

    {{ View::make('footer') }}

</body>

</html>
