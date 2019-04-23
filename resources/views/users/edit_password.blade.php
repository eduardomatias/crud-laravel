@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="pull-left">Alterar senha</h2>
        </div>
    </div>

    @include('flash::message')        
    @include('core-templates::common.errors')

    {!! Form::open(['route' => 'users.password']) !!}

        <div class="row">

            <!-- Password Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('new_password', 'Senha:', ['class' => 'required']) !!}
                {!! Form::password('new_password', ['class' => 'form-control', 'required' => true]) !!}
            </div>

            <!-- Password Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('repeat_password', 'Repita a senha:', ['class' => 'required']) !!}
                {!! Form::password('repeat_password', ['class' => 'form-control', 'required' => true]) !!}
            </div>

            <!-- Submit Field -->
            <div class="form-group col-sm-12">
                {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
                <a href="{!! URL::previous() !!}" class="btn btn-secondary">Cancelar</a>
            </div>

        </div>

    {!! Form::close() !!}
@endsection