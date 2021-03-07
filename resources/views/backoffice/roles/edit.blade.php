@extends('layouts.backoffice_master')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - Edit</title>
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
                        <h5 class="card-title">Roles</h5>
                    </div>

                    <div class="col-5">
                       
                    </div>
                    <div class="col-2 ">

                    </div>

                </div>
                <br>
                <div>
                
                
                    {!! Form::open(['route' => ['backoffice.roles.update',  $roles->id]]) !!}
                    
                    {{ csrf_field() }}
                    
                    <div class="custom-control custom-switch">                        
                        {!! Form::checkbox('is_active', '1', $roles->is_active, ['class' => 'form-control', 'class' => 'custom-control-input', 'id'=>'customSwitches']) !!}
                        {!! Form::label('customSwitches', 'Active', ['class' => 'form-control', 'class' => 'custom-control-label']) !!}
                    </div>
                    <br>
                    <div class="form-group">
                        {!! Form::label('display_name', 'Display Name') !!}
                        {!! Form::text('display_name', $roles->display_name, ['class' => 'form-control', 'required']) !!}
                    </div>
                   
                    <div class="form-group">
                        {!! Form::label('msg', 'Description') !!}
                        {!! Form::textarea('msg',  $roles->description, ['class' => 'form-control']) !!}
                    </div>
             
             <div class="form-group">
                 {!! Form::label('name', 'Name - NOT Editable') !!}
                 {!! Form::text('name', $roles->name, ['class' => 'form-control']) !!}
             </div>
                    <a class="btn btn-outline-secondary" href="{!! URL::previous() !!}"><span class="fa fa-arrow-left"></span>&nbsp; Back</a>
                    {!!  Form::button('<i class="fa fa-save"></i> Save', array('type' => 'submit', 'class' => 'btn btn-outline-secondary')); !!}
                    </form>
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>
</div>



@endsection

@section('foot-scripts')


@endsection