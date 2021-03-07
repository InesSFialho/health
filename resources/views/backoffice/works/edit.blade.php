@extends('layouts.backoffice_master')

@section('head-meta')
	<title>{{ str_replace('.', ' ', config('app.name')) }} - {{ __('Edit') }}</title>
@endsection

@section('head-scripts')
	{{-- expr --}}
@endsection

@section('content')
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">{{ __('Edit') }} </h5>
					<form action="{{ route('works.update', $work->id) }}" method="POST">
						@csrf
						@method('PUT')
						<label>{{ __('Name') }}</label>
						<input class="form-control {{ $errors->has('email') ? "is-invalid" : "" }}" type="text" name="name" value="{{ $work->name }}" maxlength="255" autofocus required>
						<small class="text-muted fa-pull-right">max. 255</small>
						<small class="text-danger">{{ $errors->first('name') }}</small>
						<br>
						<label>{{ __('Value') }}</label>
						<input class="form-control" type="number" name="value" value="{{ $work->value }}" step="0.1">
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