<li class="nav-item">
    <a class="nav-link {{ Request::is('produtos') ? 'active' : '' }}" href="{!! route('produtos.index') !!}">Produtos</a>
</li>

<li class="nav-item {{ Request::is('usuarios*') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('usuarios.index') !!}">Usuarios</a>
</li>

