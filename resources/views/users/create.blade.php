@extends('layouts.main')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h2 class="pull-left">Cadastrar Usuário</h2>
            </div>
        </div>

        @include('core-templates::common.errors')

        {!! Form::model($user, ['route' => ['users.store'], 'method' => 'post']) !!}

            <div class="row">
                @include('users.fields')
            </div>

        {!! Form::close() !!}
@endsection
