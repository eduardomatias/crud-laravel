<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
	<h5 class="my-0 mr-md-auto font-weight-normal">{{ config('app.name') }}</h5>
	@if ($usuarioRestrito)
		<nav class="my-2 my-md-0 mr-md-3">
			<a class="p-2 text-dark" href="#"><i class="fa fa-user"></i> Perfil</a>
		</nav>
		<a class="btn btn-outline-danger" href="{{ url('login') }}">Sair</a>
	@else
		
	@endif
</div>