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
    <meta property="og:description" content="With the help of the Smash Up Randomizer, factions of the card game Smash Up can be shuffled and assigned to players." />
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
    <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="fa5be6e6-ca00-4fe5-8b18-f965aa6731fa" data-blockingmode="auto" type="text/javascript"></script>
    <!-- Matomo -->
    <script>
        var _paq = window._paq = window._paq || [];
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
        var u="https://smashuprandomizer.matomo.cloud/";
        _paq.push(['setTrackerUrl', u+'matomo.php']);
        _paq.push(['setSiteId', '1']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.async=true; g.src='https://cdn.matomo.cloud/smashuprandomizer.matomo.cloud/matomo.js'; s.parentNode.insertBefore(g,s);
        })();
    </script>
    <!-- End Matomo Code -->
</head>

<body class="text-bg-dark bg-black">
    <nav class="navbar navbar-expand-lg fixed-top px-3 py-2 bg-dark bg-opacity-75 backdrop-filter">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/favicons/favicon.ico') }}" class="img-fluid me-2" alt="Logo" width="30" height="30">
                <span class="font-weight-bold text-white">Smash Up Randomizer</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white hover-effect" href="{{ route('factionList') }}">Factions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white hover-effect" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white hover-effect" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <style>
        .backdrop-filter {
            backdrop-filter: blur(10px);
        }
        .hover-effect {
            transition: all 0.3s ease;
        }
        .hover-effect:hover {
            color: #17a2b8 !important;
            transform: translateY(-2px);
        }
    </style>