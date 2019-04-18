@extends('layouts.login')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-4">
        <form class="form-signin" role="form" method="POST" action="{{ url('/login') }}">
            {!! csrf_field() !!}

            <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                <div class="col-md-12">
                    <label class="control-label">Usuário</label>
                    <input type="login" class="form-control" name="login" value="{{ old('login') }}">
                    @if ($errors->has('login'))
                        <span class="help-block">
                            <strong>{{ $errors->first('login') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="col-md-12">
                    <label class="control-label">Senha</label>
                    <input type="password" class="form-control" name="password">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-sign-in"></i> Entrar
                    </button>
                    <!-- <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a> -->
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
