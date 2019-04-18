<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        <link rel="stylesheet" href="{{ url('/css/app.css?v=1') }}">
        <link rel="stylesheet" href="{{ url('/css/custom.css?v=1') }}">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
        {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> --}}
        @yield('head')
    </head>
    <body class="d-flex flex-column">
        @include('layouts.header')
        <section class="container-fluid flex-grow">
            <div id="app" class="container py-3 conteudo">
                <div class="row">
                    <div class="col-sm-2">
                        <ul class="nav nav-pills nav-stacked">
                            @include('.menu')
                        </ul>
                    </div>
                    <div class="col-sm-10">
                        @yield('content')
                    </div>
                </div>
                <div id='loading' class="loader loader-default"></div>
            </div>
        </section>
		<div class="row justify-content-center mt-5">
			<div class="col-sm-8">
				@include('layouts.footer')
			</div>
		</div>
    </body>
</html>
