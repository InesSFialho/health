@extends('layouts.backoffice_master')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - {{ __('Home page') }}</title>
@endsection

@section('head-script')
{{-- expr --}}
@endsection

@section('content')
<div class="row">
	@include('flash::message')
</div>
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col">
						<h5 class="card-title">{{ __('Settings') }}</h5>
					</div>
				</div>
				<div>
					{!! Form::open(['route' => 'backoffice.settings.store', 'files' => 'true']) !!}

					<div class="form-group">
						{!! Form::label('video', 'Video first page') !!}
						{!! Form::file('video', ['class' => 'form-control']) !!}
						
					</div>
					<div class="form-group">
						{!! Form::label('about', 'About') !!}
						{!! Form::text('title', $settings->title, ['class' => 'form-control']) !!}
						<textarea name="about" class="about" id="about">{{$settings->about}}</textarea>

					</div>
					<div class="form-group">
						{!! Form::label('about_en', 'About EN') !!}
						{!! Form::text('title_en', $settings->title_en, ['class' => 'form-control']) !!}
						<textarea name="about_en" class="about_en" id="about_en">{{$settings->about_en}}</textarea>

					</div>

					<div class="form-group">
						{!! Form::label('shipping_return', 'Shipping & Return') !!}
						<textarea name="shipping_return" class="shipping_return" id="shipping_return">{{$settings->shipping_return}}</textarea>

					</div>
					<div class="form-group">
						{!! Form::label('shipping_return_en', 'Shipping & Return EN') !!}
						<textarea name="shipping_return_en" class="shipping_return_en" id="shipping_return_en">{{$settings->shipping_return_en}}</textarea>

					</div>
					
					<div class="form-group">
						{!! Form::label('termsofsales', 'Politicas de Privacidade') !!}
						<textarea name="termsofsales" class="termsofsales" id="termsofsales">{{$settings->termsofsales}}</textarea>

					</div>		
					<div class="form-group">
						{!! Form::label('termsofsales_en', 'Politicas de Privacidade EN') !!}
						<textarea name="termsofsales_en" class="termsofsales_en" id="termsofsales_en">{{$settings->termsofsales_en}}</textarea>

					</div>

					{!! Form::button('<i class="fa fa-save"></i> Save', array('type' => 'submit', 'class' => 'btn btn-outline-secondary')); !!}

					{!! Form::close() !!}
				</div>

			</div>
		</div>
	</div>
</div>
@endsection

@section('foot-scripts')


<script src="{{ asset('js/summernote.js') }}"></script>
<script>
	$(document).ready(function() {
		$('.about').summernote({
			toolbar: [
				// [groupName, [list of button]]
				['style', ['bold', 'italic', 'underline', 'clear']],
				['insert', ['link']],
			]
		});
		$('.shipping_return').summernote({
			toolbar: [
				// [groupName, [list of button]]
				['style', ['bold', 'italic', 'underline', 'clear']],
				['insert', ['link']],
			]
		});
		$('.termsofsales').summernote({
			toolbar: [
				// [groupName, [list of button]]
				['style', ['bold', 'italic', 'underline', 'clear']],
				['insert', ['link']],
			]
		});
		$('.about_en').summernote({
			toolbar: [
				// [groupName, [list of button]]
				['style', ['bold', 'italic', 'underline', 'clear']],
				['insert', ['link']],
			]
		});
		$('.shipping_return_en').summernote({
			toolbar: [
				// [groupName, [list of button]]
				['style', ['bold', 'italic', 'underline', 'clear']],
				['insert', ['link']],
			]
		});
		$('.termsofsales_en').summernote({
			toolbar: [
				// [groupName, [list of button]]
				['style', ['bold', 'italic', 'underline', 'clear']],
				['insert', ['link']],
			]
		});
	});
</script>
@endsection