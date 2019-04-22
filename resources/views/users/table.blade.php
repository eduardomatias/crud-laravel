<table class="table table-responsive" id="users-table">
    <thead>
        <th style="width: 100%">Name</th>
        <th>Email</th>
        <th>Admin</th>
        <th>Cadastrado</th>
        <th>Alterado</th>
        <th>Ações</th>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{!! $user->name !!}</td>
            <td>{!! $user->email !!}</td>
            <td>{!! Helper::parseSitu($user->admin) !!}</td>
            <td>{!! Helper::parseDate($user->created_at) !!}</td>
            <td>{!! Helper::parseDate($user->updated_at) !!}</td>
            <td>
                {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                <div class='btn-group crud-btn-group'>
                    <a href="{!! route('users.show', [$user->id]) !!}" class='btn btn-primary btn-xs'><i class="fa fa-eye"></i></a>
                    <a href="{!! route('users.edit', [$user->id]) !!}" class='btn btn-primary btn-xs'><i class="fa fa-edit"></i></a>
                    {!! Form::button('<i class="fa fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Deseja excluir o registro?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
