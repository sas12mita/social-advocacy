<!doctype html>
<html lang="en" data-lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@stack('title')</title>
    <link rel="icon" href="{{ asset('assets/images/bnc-logo.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-custom-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <script src="https://kit.fontawesome.com/caef87a749.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Font Awesome 6 Free -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

</head>

<body>

    @include('fronend.layout.header')


    <main>

        @yield('content')

    </main>

    @include('fronend.layout.footer')


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script>
        @if(session('success'))

        Swal.fire({
            icon: 'success',
            title: "Success",
            text: "{{ session('success') }}",
            confirmButtonColor: '#1D8D3A',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: true,
        });
        @elseif(session('error'))

        Swal.fire({
            icon: 'error',
            title: "Error",
            text: "{{ session('error') }}",
            confirmButtonColor: '#1D8D3A',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: true,
        });

        @endif
    </script>

    @stack('scripts')


</body>

</html>