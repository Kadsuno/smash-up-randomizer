<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Smash Up Randomizer</title>

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('images/favicons/site.webmanifest') }}">
</head>

<body class="text-bg-dark">
  <nav class="navbar navbar-expand-lg navbar-light bg-light px-5">
    <div class="container px-5">
      <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('images/favicons/favicon.ico') }}" class="img-fluid" alt=""></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-black" href="#" id="navbarDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              {{ __('frontend.nav_help') }}
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="{{ route('smash-up') }}">{{ __('frontend.help_smashup_header') }}</a>
              </li>
              <li><a class="dropdown-item" href="{{ route('smash-up-randomizer') }}">{{ __('frontend.help_howto_header')
                  }}</a></li>
            </ul>
          </li>
        </ul>

        
          <a class="btn btn-primary" href="{{ route('login') }}">
            <i class="far fa-user">Login</i>
          </a>
      

        <ul class="navbar-nav mb-2 mb-lg-0 ms-2">
          <li class="nav-item dropdown">
            <a class="text-decoration-none dropdown-toggle text-black" href="#" id="navbarDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              <span class="flag-icon flag-icon-{{ app()->getLocale() }}"></span> {{ strtoupper(app()->getLocale()) }}
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              @foreach($available_locales as $locale_name => $available_locale)
              @if($available_locale !== $current_locale)
              <li>
                <a class="dropdown-item" href="/public/language/{{ $available_locale }}"><span class="flag-icon flag-icon-{{ $available_locale }}"></span> {{ strtoupper($available_locale) }}</a>
              </li>
              @endif
              @endforeach
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>