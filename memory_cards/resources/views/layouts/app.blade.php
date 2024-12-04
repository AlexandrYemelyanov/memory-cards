<!DOCTYPE html>
@php
    $locale = str_replace('_', '-', app()->getLocale());
    $user = Illuminate\Support\Facades\Auth::user();
@endphp
<html lang="{{ $locale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    @vite('resources/css/app.css')
</head>
<body style="background-color: rgb(33, 37, 41)" class="bg-dark">
<div class="container mt-4">
    <h1>--{{ $locale }}--</h1>
    <div id="app" data-trans='{{ json_encode(trans('messages')) }}'>
        <memory-card-menu
            :locale="'{{ $locale }}'"
            :user='@json($user)'
            :current-url="'{{ Request::path() }}'">
        </memory-card-menu>
        @yield('content')
    </div>
</div>
@vite('resources/js/app.js')
</body>
</html>
