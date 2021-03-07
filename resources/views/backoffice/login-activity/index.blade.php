@extends('layouts.backoffice_master')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - Atividade</title>
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
						<h5 class="card-title">Atividade</h5>
					</div>

					<div class="col-5">
						
					</div>
					<div class="col-2 ">
						
					
					</div>

				</div>
				<br>
				<div class="table-responsive ">
				<form action="{{ route('loginActivities.search') }}" method="GET">
						<div class="input-group mb-3">

							<input type="text" class="form-control" placeholder="" aria-describedby="basic-addon2" name="search" id="searchtext">
							<div class="input-group-append">
								<button class="btn btn-light" type="submit" id="search"><i class="fas fa-search"></i> &nbsp;&nbsp;{{ __('Search') }}</button>
							</div>
						</div>
					</form>
					<table class="table table-striped">
						<thead>
							<tr>
								<th scope="col">ID</th>
								<th scope="col">Utilizador</th>
								<th scope="col">IP</th>
								<th scope="col">Data e Hora Login</th>
							</tr>
						</thead>
						<tbody>
							@foreach($loginActivities as $loginActivitie)
							<tr scope="row">
								<td>{{ $loginActivitie->id }}</td>
								<td>{{ $loginActivitie->name }}</td>
								<td>{{ $loginActivitie->ip_address }}</td>
								<td>{{ $loginActivitie->created_at }}</td>
								<td>{{ $loginActivitie->updated_at }}</td>

							</tr>
							
							@endforeach

						</tbody>
					</table>
					{!! $loginActivities->render() !!}
				</div>

			</div>
		</div>
	</div>
</div>



@endsection

@section('foot-scripts')

<script>
	var input = document.getElementById("searchtext");

	input.addEventListener("keyup", function(event) {

		if (event.keyCode === 13) {
			event.preventDefault();
			document.getElementById("search").click();
		}
	});
</script>

@endsection