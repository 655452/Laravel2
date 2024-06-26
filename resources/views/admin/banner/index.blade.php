@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('banner.banners') }}</h1>
        {{ Breadcrumbs::render('banners') }}
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    @can('banner_create')
                        <div class="card-header">
                            <a href="{{ route('admin.banner.create') }}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> {{ __('banner.add_banner') }}</a>
                        </div>
                    @endcan

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="sortable-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fas fa-th"></i>
                                        </th>
                                        <th>{{ __('levels.image') }}</th>
                                        <th>{{ __('levels.restaurant') }}</th>
                                        <th>{{ __('levels.title') }}</th>
                                        <th>{{ __('levels.status') }}</th>
                                        @if (auth()->user()->can('banner_edit') || auth()->user()->can('banner_delete'))
                                                <th>{{ __('levels.actions') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody data-url="{{ route('admin.sort.banner') }}">
                                    @if(!blank($banners))
                                        @foreach($banners as $banner)
    
                                            <tr data-id="{{ $banner->id}}">
                                                <td>
                                                  <div class="sort-handler">
                                                    <i class="fas fa-th"></i>
                                                  </div>
                                                </td>
                                                <td>
                                                    <img src="{{ $banner->image }}" class="img-thumbnail banner-thum mt-4 mb-3"> 
                                                </td>
                                                <td>{{$banner->restuarant->name }} </td>
                                                <td>{{ Str::limit($banner->title, 60, '...') }} </td>
                                                <td>
                                                    @if ($banner->status==5)
                                                        {{ ('Active') }}
                                                    @else
                                                        {{ ('Inactive') }}
                                                    @endif
                                                </td>
                                                @if (auth()->user()->can('banner_edit') || auth()->user()->can('banner_delete'))
                                                    <td>
                                                        @if(auth()->user()->can('banner_edit')) 
                                                            <a href="{{ route('admin.banner.edit', $banner) }}" class="btn btn-sm btn-icon float-left btn-primary ml-2"
                                                            data-toggle="tooltip" data-placement="top" title="Edit">
                                                                <i class="far fa-edit"></i>
                                                            </a>
                                                        @endif
                                                        
                                                        @if(auth()->user()->can('banner_delete')) 
                                                            <form class="float-left pl-2" action="{{ route('admin.banner.destroy', $banner) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/banner/table.js') }}"></script>
@endsection