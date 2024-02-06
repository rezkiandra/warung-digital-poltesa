<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/png" href="{{ asset('modernize/src/assets/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('/modernize/src/assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('modernize/src/assets/css/icons/tabler-icons/tabler-icons.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title') - Warung Digital</title>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        {{-- sidebar --}}
        @include('components.sidebar')
        {{-- sidebar end --}}

        {{-- header --}}
        @include('components.header')
        {{-- end header --}}

        <div class="container-fluid">
            {{-- content --}}
            {{ $slot }}
            {{-- end content --}}

            {{-- footer --}}
            @include('components.footer')
            {{-- end footer --}}
        </div>
    </div>

    <script src="{{ asset('modernize/src/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('modernize/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('modernize/src/assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('modernize/src/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('modernize/src/assets/libs/simplebar/dist/simplebar.js') }}"></script>
</body>

</html>
