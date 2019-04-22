@extends('layouts.main')

@section('css')
@endsection

@section('content')
        @include('flash::message')        
        @include('core-templates::common.errors')

        <div class="row">
            <div class="col-sm-12">
                <h2 class="pull-left">Editar Usuário</h2>
            </div>
        </div>

        {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch']) !!}

            <div class="row">
                @include('users.fields')
            </div>

        {!! Form::close() !!}
@endsection

@section('js')
@endsection