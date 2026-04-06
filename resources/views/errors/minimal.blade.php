<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        @vite(['resources/css/app.css'])
    </head>
    <body class="min-h-screen bg-zinc-950 antialiased">
        <div class="flex min-h-screen items-center justify-center px-4 py-12">
            <div class="max-w-xl text-center">
                <p class="text-6xl font-black text-cyan-500/90 sm:text-7xl">@yield('code')</p>
                <p class="mt-4 text-lg font-medium text-zinc-300">@yield('message')</p>
            </div>
        </div>
    </body>
</html>
