<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Inventory') | Inventory System</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('layouts.navigation')

    <main class="container">
        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        @if (session('error'))
            <x-alert type="danger">{{ session('error') }}</x-alert>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        PemrogramanWeb_Zahra Khairani_250180073
    </footer>
</body>
</html>
