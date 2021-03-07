@extends('layouts.backoffice_master')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - {{ __('Works') }}</title>
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
				<div class="float-right">
					<a href="{{ route('works.create') }}" class="collapsed" data-parent="#sidebar">
						<button type="submit" class="btn btn-outline-secondary" title="{{ __('New') }}"><span class="fa fa-plus"></span>&nbsp;&nbsp;{{ __('New') }}</button>
					</a>
				</div>
				<br>
				<h5 class="card-title">{{ __('Opened Works') }}</h5>
				<br>
				<div class="table-responsive">
				{{-- <form action="{{ route('works.search') }}" method="GET">
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="" aria-describedby="basic-addon2" name="search" id="searchtext">
							<div class="input-group-append">
								<button class="btn btn-light" type="submit" id="search"><i class="fas fa-search"></i> &nbsp;&nbsp;{{ __('Search') }}</button>
							</div>
						</div>
					</form> --}}
					<table class="table">
						<thead>
							<tr>
								<th class="text-center" style="width: 5%"></th>
								<th class="text-center" style="width: 5%">ID</th>
								<th class="text-left" style="width: 40%">{{ __('Name') }}</th>
								<th class="text-right" style="width: 30%">{{ __('Cost Estimate') }}</th>
								<th class="text-center" style="width: 1%"></th>
							</tr>
						</thead>
						<tbody>
							@forelse($opened_works as $work)
								<tr scope="row">
									<td class="text-center">
										<form action="{{ route('works.status-update', $work->id) }}" method="POST">
											@csrf
											@method('PUT')
											<a href="#" onclick="$(this).closest('form').submit()">
												<i class="text-success fa fa-circle" title="{{__('Opened')}}"></i>
											</a>
										</form>
									</td>
									<td class="text-center">{{ $work->id }}</td>
									<td><a href="{{ route('works.show', $work->id ) }}">{{ $work->name }}</a></td>
									<td class="text-right">
										<a href="{{ route('works.show', $work->id ) }}">
											{{ number_format($work->value, 2) }}&nbsp;€
										</a>
									</td>
									<td class="d-flex">
										<a class="ml-1" href="{{ route('works.edit', $work->id) }}"><i class="fa fa-edit mr-1" title="{{ __('Edit') }}"></i></a>
										<a class="ml-1" href="{{ route('works.delete', $work->id) }}"><i class="fa fa-trash mr-1" title="{{ __('Delete') }}"></i></a>
									</td>
								</tr>
							@empty
								<td colspan="5">{{ __('No Opened Works') }}!</td>
							@endforelse
						</tbody>
						<tfoot>
								{{-- <tr ><td colspan="5">	{{ $works->links() }}</td></tr> --}}
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<br>
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">{{ __('Closed Works') }}</h5>
				<br>
				<div class="table-responsive">
				{{-- <form action="{{ route('works.search') }}" method="GET">
						<div class="input-group mb-3">

							<input type="text" class="form-control" placeholder="" aria-describedby="basic-addon2" name="search" id="searchtext">
							<div class="input-group-append">
								<button class="btn btn-light" type="submit" id="search"><i class="fas fa-search"></i> &nbsp;&nbsp;{{ __('Search') }}</button>
							</div>
						</div>
					</form> --}}
					<table class="table">
						<thead>
							<tr>
								<th class="text-center" style="width: 5%"></th>
								<th class="text-center" style="width: 5%">ID</th>
								<th class="text-left" style="width: 40%">{{ __('Name') }}</th>
								<th class="text-right" style="width: 30%">{{ __('Cost Estimate') }}</th>
								<th class="text-center" style="width: 1%"></th>
							</tr>
						</thead>
						<tbody>
							@forelse($closed_works as $work)
								<tr scope="row">
									<td class="text-center">
										<form action="{{ route('works.status-update', $work->id) }}" method="POST">
											@csrf
											@method('PUT')
											<a href="#" onclick="$(this).closest('form').submit()">
												<i class="text-danger fa fa-circle" title="{{__('Closed')}}"></i>
											</a>
										</form>
									</td>
									<td class="text-center">{{ $work->id }}</td>
									<td><a href="{{ route('works.show', $work->id ) }}">{{ $work->name }}</a></td>
									<td class="text-right">
										<a href="{{ route('works.show', $work->id ) }}">
											{{ number_format($work->value, 2) }}&nbsp;€
										</a>
									</td>
									<td class="d-flex">
										<a class="ml-1" href="{{ route('works.edit', $work->id) }}"><i class="fa fa-edit mr-1" title="{{ __('Edit') }}"></i></a>
										<a class="ml-1" href="{{ route('works.delete', $work->id) }}"><i class="fa fa-trash mr-1" title="{{ __('Delete') }}"></i></a>
									</td>
								</tr>
							@empty
								<td colspan="5">{{ __('No Closed Works') }}!</td>
							@endforelse
						</tbody>
						<tfoot>
								{{-- <tr ><td colspan="5">	{{ $works->links() }}</td></tr> --}}
						</tfoot>
					</table>
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