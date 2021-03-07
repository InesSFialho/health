@extends('layouts.backoffice_master')

@section('head-meta')
	<title>{{ str_replace('.', ' ', config('app.name')) }} - {{ __('Criar Utilizador') }}</title>
@endsection

@section('head-scripts')
	{{-- expr --}}
@endsection

@section('content')
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">{{ __('New User') }}</h5>
					<form action="{{ route('dashboard.users.store') }}" method="POST">
						@csrf
						<div class="row">
							<div class="form-group col-6">
								<label>{{ __('Name') }}</label>
								<input type="text" name="name" class="form-control {{ $errors->has('name') ? "is-invalid" : "" }}" maxlength="255">
								<small class="text-muted fa-pull-right">max. 255</small>
								<small class="text-danger">{{ $errors->first('name') }}</small>
							</div>
							<div class="form-group col-6">
								<label>{{ __('Email') }}</label>
								<input type="text" name="email" class="form-control {{ $errors->has('email') ? "is-invalid" : "" }}" maxlength="255">
								<small class="text-muted fa-pull-right">max. 255</small>
								<small class="text-danger">{{ $errors->first('email') }}</small>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-4">
								<label>{{ __('Role') }}</label>
								<select class="selectpicker form-control {{ $errors->has('role') ? "is-invalid" : "" }}" name="role">
									<option value="">{{ __('-- Select a role --') }}</option>
									@forelse ($roles as $role)
										<option value="{{ $role->id }}">{{ $role->display_name }}</option>
									@empty
										{{ __('no roles available!') }}
									@endforelse
								</select>
								<small class="text-danger">{{ $errors->first('role') }}</small>
							</div>
							<div class="form-group col-4">
							<label for="company" class="control-label required">{{ __('Permissions') }}</label>
							<select class="selectpicker form-control" id="permissions_user" name="permissions_user[]" title="Permissions" data-live-search="true" multiple data-actions-box="true">
								@foreach($permissions as $permission)
								<option value="{{$permission->id}}">{{$permission->display_name}}</option>
								@endforeach
							</select>
							<span><small class="text-muted mb-2">{{ __('If not select the user goes have all Permissions') }}</small></span>
						</div>
						<div class="form-group col-4">
								<label>{!! __('Company') !!}</label>
								<select class="selectpicker form-control {{ $errors->has('company') ? "is-invalid" : "" }}" name="company">
									<option value="">{!! __('-- Select a company --') !!}</option>
									@forelse ($companies as $company)
										<option value="{{ $company->id }}">{{ $company->name }}</option>
									@empty
										<option value="">{!! __('no companies') !!}</option>
									@endforelse
								</select>
								<small class="text-danger">{{ $errors->first('company') }}</small>
							</div>
						</div>
						<br>
						<button class="btn btn-outline-secondary float-right" type="submit"><i class="fa fa-save"></i>&nbsp; {!! __('Save') !!}</button>
					</form>
				</div>
			</div>
			<br>
        <a class="btn btn-white" href="{{ route('backoffice.users.index') }}"><span class="fa fa-arrow-left"></span>&nbsp; {!! __('Users') !!}</a>
		</div>
	</div>
@endsection

@section('foot-scripts')
	{{-- expr --}}
@endsection