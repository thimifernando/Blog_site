@extends('layouts.app') 
@section('title', 'Welcome to PixelSage') 
@section('content')
<body style="margin: 0; padding: 0; font-family: 'Roboto', sans-serif; background-color: #f2f2f2;">
    <main style="padding: 20px; max-width: 800px; margin: 0 auto;">
        <div style="text-align: center;">
            <h2 style="color: #4CAF50; font-size: 50px; font-weight: 700; margin-bottom: 20px; text-shadow: 2px 2px #ccc;">Welcome to PixelSage</h2>
            <p style="font-size: 20px; color: #555; margin-bottom: 40px; line-height: 1.6;">
                Your one-stop solution for creative designs, unique ideas, and cutting-edge innovation. Explore our platform to discover endless possibilities and let your creativity soar!
            </p>
            
            <a href="{{route('home')}}" style="display: inline-block; padding: 15px 30px; font-size: 18px; color: #fff; background-color: #4CAF50; border-radius: 5px; text-decoration: none; box-shadow: 0 4px 8px rgba(0,0,0,0.2); transition: background-color 0.3s;">
                Explore Now
            </a>
        </div>
    </main>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>
@endsection
