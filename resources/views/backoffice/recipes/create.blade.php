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
					<h5 class="card-title">{{ __('New Recipe') }}</h5>
					<br>
					<form action="{{ route('recipes.store') }}" method="POST">
						@csrf
						<div class="row">
							<div class="form-group col-12">
								<label>{{ __('Title') }}</label>
								<input type="text" name="title" class="form-control {{ $errors->has('title') ? "is-invalid" : "" }}" maxlength="255">
								<small class="text-muted fa-pull-right">max. 255</small>
								<small class="text-danger">{{ $errors->first('title') }}</small>
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