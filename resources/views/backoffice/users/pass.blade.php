@extends('layouts.backoffice_master')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - Mudar password</title>
@endsection

@section('head-scripts')
{{-- expr --}}
@endsection

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<div id="edit-form">
				<form action="{{ route('dashboard.users.passstore') }}" method="POST">
						@csrf
						<div class="row">
							<div class="form-group col-6">
								<label>{{ __('Name') }}</label>
								
								<input type="hidden" name="id" class="form-control" readonly  value="{{ $user->id }}" >
								<input type="text" name="name" class="form-control" readonly  value="{{ $user->name }}" >
							</div>
						</div>
						<div class="row">
							<div class="form-group col-6">
								<label>{{ __('New Password') }}</label>
								<input type="password" name="password" class="form-control"  >
							</div>
						</div>
						<br>
						<button class="btn btn-outline-secondary float-right" type="submit"><i class="fa fa-save"></i>&nbsp; {!! __('Save') !!}</button>
					
				</form>
					
			</div>
		</div>
	</div>
</div>
@endsection

@section('foot-scripts')
{{-- expr --}}
@endsection