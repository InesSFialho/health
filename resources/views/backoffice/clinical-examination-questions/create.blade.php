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
					<h5 class="card-title">{{ __('New Clinical Examination Question') }}</h5>
					<br>
					<form action="{{ route('clinical-examination-questions.store') }}" method="POST">
						@csrf
						<div class="row">
							<div class="form-group col-12">
								<label>{{ __('Question') }}</label>
								<input type="text" name="question" class="form-control {{ $errors->has('question') ? "is-invalid" : "" }}" maxlength="255">
								<small class="text-muted fa-pull-right">max. 255</small>
								<small class="text-danger">{{ $errors->first('question') }}</small>
							</div>
						</div>
						<br>
						<button class="btn btn-outline-secondary float-right" type="submit"><i class="fa fa-save"></i>&nbsp; {!! __('Save') !!}</button>
						<a class="btn btn-outline-secondary" href="{{ route('clinical-examination-questions.index') }}"><span class="fa fa-arrow-left"></span>&nbsp; {{ __('Back') }}</a>
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