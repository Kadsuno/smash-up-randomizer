<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Smash Up Randomizer Backend</title>

    @vite(['resources/sass/app.scss'])
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicons/site.webmanifest') }}">  
</head>

<body class="bg-black text-white">
    <nav x-data="{ open: false }" class="navbar navbar-expand-lg navbar-dark fixed-top bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
                <img src="{{ asset('images/favicons/favicon.ico') }}" class="img-fluid me-2" alt="Logo" width="30" height="30">
                <span class="font-weight-bold">Smash Up Randomizer</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-regular fa-user me-2"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow logout-btn" aria-labelledby="navbarDropdown">
                            <li>
                              <form method="POST" action="{{ route('logout') }}">
                                @csrf
            
                                <button type="submit" class="dropdown-item d-flex align-items-center btn text-black w-100 text-start logout-btn"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    <i class="fa-solid fa-arrow-right-from-bracket me-2"></i>
                                    <span>{{ __('backend.logout') }}</span>
                                </button>
                            </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <style>
        .logout-btn:hover {
            background-color: #6c757d;
            color: white !important;
        }
    </style>