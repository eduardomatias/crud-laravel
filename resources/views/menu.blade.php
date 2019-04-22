<li class="nav-item">
    <a class="nav-link {{ Request::is('users*') ? 'active' : '' }}" href="{!! route('users.index') !!}">Usuários</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('menu2*') ? 'active' : '' }}" href="{!! route('users.index') !!}">Menu 2</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('menu3*') ? 'active' : '' }}" href="{!! route('users.index') !!}">Menu 3</a>
</li>

