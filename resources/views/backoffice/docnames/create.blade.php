@extends('layouts.backoffice_master')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - {{ __('Document Names') }}</title>
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
                <h5 class="card-title">{{ __('New') }}</h5>
                <form action="{{ route('docnames.store') }}" method="POST">
                    @csrf
                    <label>{{ __('Name') }}</label>
                    <input class="form-control {{ $errors->has('email') ? "is-invalid" : "" }}" type="text" name="name" maxlength="255" autofocus required>
                    <small class="text-muted fa-pull-right">max. 255</small>
                    <small class="text-danger">{{ $errors->first('name') }}</small>
                    <br>
                    <div class="form-group">
                        {!! Form::label('slug', 'Slug - if left blank it will be automatically generated') !!}
                        {!! Form::text('slug', null, ['class' => 'form-control']) !!}
                    </div>
                    <br>
                    <a class="btn btn-outline-secondary" href="{!! URL::previous() !!}"><span class="fa fa-arrow-left"></span>&nbsp; {{ __('Back') }}</a>
                    
                    <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-save"></i>&nbsp; {!! __('Save') !!}</button>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection

@section('foot-scripts')


@endsection