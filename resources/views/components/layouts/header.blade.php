<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="SmashUp Randomizer">
    <meta name="description" content="With the help of the Smash Up Randomizer, factions of the card game Smash Up can be shuffled and assigned to players.">
    <meta name="keywords" content="SmashUp, Card game, Card, Game, Randomizer">
    <meta property="og:title" content="Assigning randomized factions" />
    <meta property="og:image" content="{{ asset('images/favicons/favicon-32x32.png') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="SmashUp Randomizer" />
    <meta property=“og:description“ content="With the help of the Smash Up Randomizer, factions of the card game Smash Up can be shuffled and assigned to players." />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Assigning randomized factions" />
    <meta name="twitter:description" content="With the help of the Smash Up Randomizer, factions of the card game Smash Up can be shuffled and assigned to players." />
    <meta name="twitter:image" content="{{ asset('images/favicons/favicon-32x32.png') }}" />

    <title>Smash Up Randomizer</title>

    <link rel="stylesheet" type="text/css" href="{{asset("vendor/cookie-consent/css/cookie-consent.css")}}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicons/site.webmanifest') }}">
</head>

<body class="text-bg-dark">
    <nav class="navbar navbar-expand-lg bg-primary px-5">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('images/favicons/favicon.ico') }}"
                    class="img-fluid" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main_nav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('frontend.nav_help') }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item"
                                    href="{{ route('smash-up') }}">{{ __('frontend.help_smashup_header') }}</a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="{{ route('smash-up-randomizer') }}">{{ __('frontend.help_howto_header') }}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>