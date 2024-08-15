<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        <!-- Zoekbalk -->
        <div class="container mx-auto p-4">
            <form action="{{ route('profile.search') }}" method="GET" class="flex items-center">
                <input type="text" name="query" class="form-input rounded-l-md border-2 border-r-0 border-gray-300 p-2 w-full" placeholder="Search users...">
                <button type="submit" class="bg-blue-500 text-white p-2 rounded-r-md border-2 border-blue-500">
