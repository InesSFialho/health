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
					<h5 class="card-title">{{ __('New Pathology') }}</h5>
					<br>
					<form action="{{ route('pathologies.store') }}" method="POST">
						@csrf
						<div class="row">
							<div class="form-group col-12">
								<label>{{ __('Name') }}</label>
								<input type="text" name="name" class="form-control {{ $errors->has('name') ? "is-invalid" : "" }}" maxlength="255">
								<small class="text-muted fa-pull-right">max. 255</small>
								<small class="text-danger">{{ $errors->first('name') }}</small>
							</div>
						</div>
						<br>
						<button class="btn btn-outline-secondary float-right" type="submit"><i class="fa fa-save"></i>&nbsp; {!! __('Save') !!}</button>
					</form>
				</div>
			</div>
			<br>
		</div>
	</div>
@endsection

@section('foot-scripts')
	{{-- expr --}}
@endsection