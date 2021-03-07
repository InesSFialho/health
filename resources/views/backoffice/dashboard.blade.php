@extends('layouts.backoffice_master')

@section('head-meta')
	<title>{{ str_replace('.', ' ', config('app.name')) }} - Dashboard</title>
@endsection

@section('head-script')
	{{-- expr --}}
@endsection

@section('content')
	<div class="row">
	@include('flash::message')
	</div>
	
@endsection

@section('foot-scripts')
@endsection