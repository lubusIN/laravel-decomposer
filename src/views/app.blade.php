<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    @include('Decomposer::layouts.header')
    @stack('styles')
</head>

<body>
    @include('Decomposer::index')
    @include('Decomposer::layouts.footer')
    @stack('scripts')
</body>

</html>