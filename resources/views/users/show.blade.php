@extends('layouts.main')

@section('content')
    @include('users.show_fields')

    <div class="form-group">
        <a href="{!! route('users.index') !!}" class="btn btn-secondary">Voltar</a>
    </div>
@endsection
