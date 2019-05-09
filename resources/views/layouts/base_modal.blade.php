{{-- Layout base para modal --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row">
    <div class="col-sm-12">
        @yield('content')
    </div>
</div>