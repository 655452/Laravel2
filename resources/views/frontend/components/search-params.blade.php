<form action="{{ route('search') }}" class="search" method="GET">
    <div class="input-group w-100">
        <input type="text" class="form-control" placeholder="{{ __('frontend.search') }}" name="name" value="{{ session('query') }}">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
</form>
