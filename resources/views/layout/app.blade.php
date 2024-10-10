<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - SafeVax</title>
    <link rel="icon" type="image/png" href="{{ asset('public/favicon.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" />
    @stack('styles')
</head>

<body>
    @include('layout.partials.nav')
    <section class="section">
        <div class="container">
            @yield('content')
        </div>
    </section>
    @stack('scripts')
</body>

</html>
