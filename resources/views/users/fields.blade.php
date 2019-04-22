<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

<!-- Admin Field -->
<div class="form-group col-sm-6">
        {!! Form::label('admin') !!}
        {!! Form::select('admin', Helper::getComboSitu(), null, ['class' => 'form-control']) !!}
    </label>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-secondary">Cancelar</a>
</div>
