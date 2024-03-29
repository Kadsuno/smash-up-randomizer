<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="SmashUp Randomizer">
    <meta name="description" content="With the help of the Smash Up Randomizer, factions of the card game Smash Up can be shuffled and assigned to players.">
    <meta name="keywords" content="SmashUp, Card game, Card, Game, Randomizer">
    <meta property="og:title" content="Assigning randomized factions" />
    <meta property="og:image" content="{{ asset('images/favicons/favicon.ico') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="SmashUp Randomizer" />
    <meta property=“og:description“ content="With the help of the Smash Up Randomizer, factions of the card game Smash Up can be shuffled and assigned to players." />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Assigning randomized factions" />
    <meta name="twitter:description" content="With the help of the Smash Up Randomizer, factions of the card game Smash Up can be shuffled and assigned to players." />
    <meta name="twitter:image" content="{{ asset('images/favicons/favicon.ico') }}" />
    <meta name="robots" content="index,follow" />
    <meta name="googlebot" content="index,follow" />
    <title>Smash Up Randomizer</title>
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/cookie-consent/css/cookie-consent.css')}}">
    @vite(['resources/sass/app.scss'])
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicons/site.webmanifest') }}">
</head>

<body class="text-bg-dark">
    <nav class="navbar navbar-fixed navbar-expand-lg px-5 fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('images/favicons/favicon.ico') }}" class="img-fluid" alt=""></a>
            <button class="navbar-toggler" onclick="bgNav()" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('contact') }}">
                            Contact
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>