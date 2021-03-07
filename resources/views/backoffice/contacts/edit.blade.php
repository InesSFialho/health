@extends('layouts.backoffice_master')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - {{ __('Contacts') }}</title>

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
                    <div class="col-5">
                        <h5 class="card-title">{{ __('Contacts') }}</h5>
                    </div>

                    <div class="col-5">
                       
                    </div>
                    <div class="col-2 ">

                    </div>

                </div>
                <br>
                <div>

                
                    {!! Form::open(['route' => ['backoffice.contacts.update',  $contacts->id]]) !!}
                    
                    {{ csrf_field() }}

                    <div class="custom-control custom-switch">                        
                        {!! Form::checkbox('is_active', '1', true, ['class' => 'form-control', 'class' => 'custom-control-input', 'id'=>'customSwitches']) !!}
                        {!! Form::label('customSwitches', 'Ativo', ['class' => 'form-control', 'class' => 'custom-control-label']) !!}
                    </div>
                    <br>
                    <div class="form-group">
                        {!! Form::label('name', 'Nome') !!}
                        {!! Form::text('name', $contacts->name, ['class' => 'form-control', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('msg', 'Descrição') !!}
                        {!! Form::textarea('msg',  $contacts->description, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('sort', 'Ordem') !!}
                        {!! Form::text('sort', $contacts->sort, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('hiperlink', 'Link') !!}
                        {!! Form::text('hiperlink', $contacts->hiperlink, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('icon', 'Icon') !!} 
                         {!! Form::select('icon', $icons,$contacts->icon, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('slug', 'Slug -  se deixar em branco, será gerado automaticamente') !!}
                        {!! Form::text('slug', $contacts->slug, ['class' => 'form-control']) !!}
                    </div>


                    <a class="btn btn-outline-secondary" href="{!! URL::previous() !!}"><span class="fa fa-arrow-left"></span>&nbsp; Back</a>
                    {!!  Form::button('<i class="fa fa-save"></i> Save', array('type' => 'submit', 'class' => 'btn btn-outline-secondary')); !!}
                    </form>
                    <!-- {!! Form::close() !!} -->
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
		$('#msg').summernote({
			toolbar: [
				// [groupName, [list of button]]
				['style', ['bold', 'italic', 'underline', 'clear']],
				['insert', ['link']],
			]
		});

	});
</script>

@endsection