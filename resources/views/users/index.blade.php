@extends('layouts.main')

@section('css')
@endsection

@section('content')

        @include('flash::message')

        <a class="btn btn-primary pull-right crud-btn-cadastrar" href="{!! route('users.create') !!}">Cadastrar</a>
        
        <h2 class="pull-left">Usuários</h2>

        <div class="clearfix"></div>

        @include('users.search')

        @include('users.table')
        
@endsection

@section('js')
@endsection
