@extends('layouts.backoffice_master')
@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }}</title>
@endsection

@section('head-script')

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
					<a href="{{ route('backoffice.permissions.create') }}" class="collapsed" data-parent="#sidebar">
						<button type="submit" class="btn btn-outline-secondary" title="{{ __('New Permission') }}"><span class="fa fa-plus"></span>&nbsp;&nbsp;{{ __('New') }}</button>
					</a>
				</div>
				<h5 class="card-title">{{ __('Permissions') }}</h5>
				<br>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th class="text-center" style="width: 5%">ID</th>
								<th class="text-left" style="width: 40%">{{ __('Display Name') }}</th>
								<th class="text-left" style="width: 40%">{{ __('Name') }}</th>
								<th class="text-center" style="width: 1%"></th>
							</tr>
						</thead>
						<tbody>
							@forelse($permissions as $permission)
								<tr scope="row">
									<td class="text-center">{{ $permission->id }}</td>
									<td>{{ $permission->display_name }}</td>
									<td>{{ $permission->name }}</td>
									<td class="d-flex">
									<a class="ml-2" href="{{ route('backoffice.permissions.edit', $permission->id) }}"><i class="fa fa-edit mr-1" title="{{ __('Edit') }}"></i></a>
										</td>
								</tr>
							@empty
								<td>no permissions!</td>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('foot-scripts')
@endsection