@extends('layouts.backoffice_master')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - {{ __('Categories') }}</title>

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
                        <h5 class="card-title">{{ __('Categories') }}</h5>
                    </div>

                    <div class="col-5">
                      
                      
                    </div>
                    <div class="col-2 ">

                    </div>

                </div>
                <br>
                <div>
                    {!! Form::open(['route' => 'backoffice.abouts.store']) !!}
                    {{ csrf_field() }}
                    <div class="custom-control custom-switch">
                        {!! Form::checkbox('is_active', '1', true, ['class' => 'form-control', 'class' => 'custom-control-input', 'id'=>'customSwitches']) !!}
                        {!! Form::label('customSwitches', 'Active', ['class' => 'form-control', 'class' => 'custom-control-label']) !!}
                    </div>
                    <br>
                    <div class="form-group">
                        {!! Form::label('name', 'Nome') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('name_en', 'Nome EN') !!}
                        {!! Form::text('name_en', null, ['class' => 'form-control', 'required']) !!}
                    </div>
                    
                   
                    
                    <a class="btn btn-outline-secondary" href="{!! URL::previous() !!}"><span class="fa fa-arrow-left"></span>&nbsp; Back</a>
                    {!! Form::button('<i class="fa fa-save"></i> Save', array('type' => 'submit', 'class' => 'btn btn-outline-secondary')); !!}

                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>
</div>



@endsection

@section('foot-scripts')


@endsection