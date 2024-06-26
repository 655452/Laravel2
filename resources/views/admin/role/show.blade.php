@extends('admin.layouts.master')

@section('main-content')

	<section class="section">
        <div class="section-header">
		<h1>{{ __('levels.roles') }}</h1>
            {{ Breadcrumbs::render('role/view') }}
        </div>

        <div class="section-body">
        	<div class="row">
	   			<div class="col-12 col-md-12 col-lg-12">
				    <div class="card">
				    	<form action="{{ route('admin.role.save-permission', $role) }}" method="POST">
				    		@csrf
				    		<div class="card-header">
						        <h3>{{ __('levels.permmission') }} - <span class="text-danger">( {{ $role->name }} )</span></h3>
						    </div>

						    <div class="card-body">
						        <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('#') }}</th>
                                            <th>{{ __('levels.module_name') }}</th>
                                            <th>{{ __('levels.create') }}</th>
                                            <th>{{ __('levels.edit') }}</th>
                                            <th>{{ __('levels.delete') }}</th>
                                            <th>{{ __('levels.show') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(count($permissionList)) { foreach($permissionList as $permission) { ?>
                                            <tr>
                                                <td data-title="{{ __('#') }}">
                                                    <input type="checkbox" id="<?=$permission->name?>" name="<?=$permission->name?>" value="<?=$permission->id?>"  <?=isset($permissions[$permission->id]) ? 'checked' : ''?> onclick="processCheck(this);" class="mainmodule"/>
                                                </td>
                                                <td data-title="{{ __('Module Name') }}">
                                                	<?=str_replace('-', ' ', ucfirst($permission->name))?>
                                                </td>
                                                <td data-title="{{ __('Create') }}">
	                                                <?php
	                                                    $permissionCreate = $permission->name.'_create';
	                                                    if(isset($permissionArray[$permissionCreate])) { ?>
	                                                        <input type="checkbox" id="<?=$permissionCreate?>" name="<?=$permissionCreate?>" value="<?=$permissionArray[$permissionCreate]?>" <?=isset($permissions[$permissionArray[$permissionCreate]]) ? 'checked' : ''?> />
	                                                <?php } else {
	                                                    echo "&nbsp;";
	                                                } ?>
                                                </td>
                                                <td data-title="{{ __('Edit') }}">
	                                                <?php
	                                                    $permissionEdit = $permission->name.'_edit';
	                                                    if(isset($permissionArray[$permissionEdit])) { ?>
	                                                        <input type="checkbox" id="<?=$permissionEdit?>" name="<?=$permissionEdit?>" value="<?=$permissionArray[$permissionEdit]?>" <?=isset($permissions[$permissionArray[$permissionEdit]]) ? 'checked' : ''?> />
	                                                <?php } else {
	                                                    echo "&nbsp;";
	                                                } ?>
                                                </td>
                                                <td data-title="{{ __('Delete') }}">
	                                                <?php
	                                                    $permissionDelete = $permission->name.'_delete';
	                                                    if(isset($permissionArray[$permissionDelete])) { ?>
	                                                        <input type="checkbox" id="<?=$permissionDelete?>" name="<?=$permissionDelete?>" value="<?=$permissionArray[$permissionDelete]?>" <?=isset($permissions[$permissionArray[$permissionDelete]]) ? 'checked' : ''?> />
	                                                <?php } else {
	                                                    echo "&nbsp;";
	                                                } ?>
                                                </td>
                                                <td data-title="{{ __('Show') }}">
	                                                <?php
	                                                    $permissionShow = $permission->name.'_show';
	                                                    if(isset($permissionArray[$permissionShow])) { ?>
	                                                        <input type="checkbox" id="<?=$permissionShow?>" name="<?=$permissionShow?>" value="<?=$permissionArray[$permissionShow]?>" <?=isset($permissions[$permissionArray[$permissionShow]]) ? 'checked' : ''?> />
	                                                <?php } else {
	                                                    echo "&nbsp;";
	                                                } ?>
                                                </td>
                                            </tr>
                                        <?php } } ?>
                                    </tbody>
                                </table>
						    </div>

					        <div class="card-footer">
		                    	<button class="btn btn-primary mr-1" type="submit">{{ __('levels.submit') }}</button>
		                  	</div>
		                </form>
					</div>
				</div>
			</div>
        </div>
    </section>

@endsection
@section('scripts')
	<script src="{{ asset('js/role/show.js') }}"></script>
@endsection
