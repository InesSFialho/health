@extends('layouts.backoffice_master_client')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - Dashboard</title>
@endsection

@section('head-scripts')

@endsection

@section('content')
<div class="row">
	<div class="col">
		@include('flash::message')
	</div>
</div>
<div class="row">
	<div class="col">
		<div class="card mb-2">
			<div class="card-body">
				<div class="row">
					<div class="col">
						<h5 class="card-title">Dashboard</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
    

</div>

@endsection

@section('foot-scripts')

@endsection