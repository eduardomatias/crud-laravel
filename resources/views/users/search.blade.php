<form action="" method="GET">
    <div class="input-group mb-3">
        <input type="hidden" name="searchFields" value="name:like;email:like">
        <input type="text" class="form-control" placeholder="Buscar por..." aria-describedby="basic-addon2" name="search" value="{{ (isset($search) ? $search : '')  }}" required>
        <div class="input-group-append">
            <button class="btn btn-outline-prymary" type="submit"><i class="fa fa-search"></i></button>
            @if(isset($search))
            <a href="{!! route('users.index') !!}" class='btn btn-danger btn-xs' title="cancelar busca">
                <i class="fa fa-times"></i>
            </a>
            @endif
        </div>
    </div>
</form>