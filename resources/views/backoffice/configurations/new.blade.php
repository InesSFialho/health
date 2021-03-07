@extends('layouts.backoffice_master')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - Páginma Principal</title>
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
						<h5 class="card-title">Configurations</h5>
					</div>
				</div>
				<div>
					{!! Form::open(['route' => 'backoffice.configurations.store', 'files' => 'true']) !!}

					<div class="form-group">
						{!! Form::label('video', 'Video first page') !!}
						{!! Form::file('video', ['class' => 'form-control']) !!}
						
					</div>
					<div class="form-group">
						{!! Form::label('about', 'About') !!}
						{!! Form::text('title', null, ['class' => 'form-control']) !!}
						<textarea name="about" class="about" id="about"> </textarea>

					</div>

					<div class="form-group">
						{!! Form::label('shipping_return', 'Shipping & Return') !!}
						<textarea name="shipping_return" class="shipping_return" id="shipping_return"> </textarea>

					</div>
					<div class="form-group">
						{!! Form::label('jewellery_care', 'Jewellery Care') !!}
						<textarea name="jewellery_care" class="jewellery_care" id="jewellery_care"> </textarea>

					</div>
					<div class="form-group">
						{!! Form::label('termsofsale', 'Terms of Sale') !!}
						<textarea name="termsofsale" class="termsofsale" id="shipping_return"> </textarea>

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
		$('.jewellery_care').summernote({
			toolbar: [
				// [groupName, [list of button]]
				['style', ['bold', 'italic', 'underline', 'clear']],
				['insert', ['link']],
			]
		});
		$('.termsofsale').summernote({
			toolbar: [
				// [groupName, [list of button]]
				['style', ['bold', 'italic', 'underline', 'clear']],
				['insert', ['link']],
			]
		});
	});
</script>
@endsection