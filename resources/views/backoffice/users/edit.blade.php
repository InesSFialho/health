@extends('layouts.backoffice_master')
@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - {{ __('Edit User') }}</title>
@endsection

@section('head-scripts')
{{-- expr --}}
@endsection

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">{{ __('Edit User') }} </h5>
				<form action="{{ route('dashboard.users.update', $user->id) }}" method="POST">
					@csrf
					@method('PUT')
					<div class="row">
						<div class="form-group col-12	">
							<div class="custom-control custom-switch">
								{!! Form::checkbox('is_active', '1', $user->is_active, ['class' => 'form-control', 'class' => 'custom-control-input', 'id'=>'customSwitches']) !!}
								{!! Form::label('customSwitches', 'Active', ['class' => 'form-control', 'class' => 'custom-control-label']) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-6">
							<label>{{ __('Name') }}</label>
							<input type="text" name="name" class="form-control {{ $errors->has('name') ? "is-invalid" : "" }}" maxlength="255" value="{{ $user->name }}">
							<small class="text-muted fa-pull-right">max. 255</small>
							@foreach ($errors->all() as $error)
							<small class="text-danger">{{ $errors->first('name') }}</small>
							@endforeach
						</div>
						<div class="form-group col-6">
							<label>{{ __('Email') }}</label>
							<input type="text" name="email" class="form-control {{ $errors->has('email') ? "is-invalid" : "" }}" maxlength="255" value="{{ $user->email }}">
							<small class="text-muted fa-pull-right">max. 255</small>
							<small class="text-danger">{{ $errors->first('email') }}</small>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-4">
							<label>{{ __('Role') }}</label>
							<select class="selectpicker form-control {{ $errors->has('company') ? "is-invalid" : "" }}" name="role">
								<option value="{{ $user->roles[0]->id }}">{{ $user->roles[0]->display_name }}</option>
								@forelse ($roles as $role)
								@if ($role->id != $user->roles[0]->id)
								<option value="{{ $role->id }}">{{ $role->display_name }}</option>
								@endif
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
								@if(array_search($permission->id,$permissions_user) !== false)
								<option value="{{$permission->id}}" selected>{{$permission->display_name}}</option>
								@else
								<option value="{{$permission->id}}">{{$permission->display_name}}</option>
								@endif
								@endforeach
							</select>
							<span><small class="text-muted mb-2">{{ __('If not select the user goes have all Permissions') }}</small></span>
						</div>
						<div class="form-group col-4">
								<label>{!! __('Company') !!}</label>
								<select class="selectpicker form-control {{ $errors->has('company') ? "is-invalid" : "" }}" name="company">
									<option value="{{ $user->company_id }}">{{ $user->company->name }}</option>
									@forelse ($companies as $company)
										@if ($company != $user->company)
											<option value="{{ $company->id }}">{{ $company->name }}</option>
										@endif
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