<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Document</title>

    <link rel="stylesheet" href="/css/app.css">
</head>
<body>

    <header>
        @include('layouts.default.header')
    </header>

    <main>
        <section id="app">
            @yield('content')
        </section>
    </main>

    @include('layouts.default.footer')

    @component('layouts.default.body_scripts')
        @yield('scripts')
    @endcomponent

</body>
</html>
