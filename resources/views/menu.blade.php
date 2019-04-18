<li class="nav-item {{ Request::is('produtos*') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('produtos.index') !!}">Produtos</a>
</li>

<li class="nav-item {{ Request::is('usuarios*') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('usuarios.index') !!}">Usuarios</a>
</li>

