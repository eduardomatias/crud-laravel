<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        <link rel="stylesheet" href="{{ url('/css/app.css?v=1') }}">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
        {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> --}}
        @yield('head')
    </head>
    <body class="d-flex flex-column">
        <section class="container-fluid flex-grow">
            <div id="app" class="container py-5 conteudo">
                <div class="row">
                    <div class="col-sm-12 content-main text-center pt-5">
                        @yield('content')
                        <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-secondary mt-5 center">Voltar</a>
                    </div>
                </div>
                <div id='loading' class="loader loader-default"></div>
            </div>
        </section>
        @include('layouts.footer')
    </body>
</html>
