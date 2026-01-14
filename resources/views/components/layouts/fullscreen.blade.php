<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Gia Phả' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
            /* Prevent native scrolling for canvas feel */
            background-color: #f3f4f6;
        }
    </style>
</head>

<body class="font-sans antialiased h-full w-full">
    {{ $slot }}
    @livewireScripts
</body>

</html>
