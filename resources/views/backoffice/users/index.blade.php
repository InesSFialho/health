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
					<a href="{{ route('dashboard.users.create') }}" class="collapsed" data-parent="#sidebar">
						<button type="submit" class="btn btn-outline-secondary" title="{{ __('New User') }}"><span class="fa fa-plus"></span>&nbsp;&nbsp;{{ __('New') }}</button>
					</a>
				</div>
				<h5 class="card-title">{{ __('Users') }}</h5>
				<br>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th class="text-center" style="width: 5%">ID</th>
								<th class="text-left" style="width: 30%">{{ __('Name') }}</th>
								<th class="text-center" style="width: 40%">Email</th>
								<th class="text-center" style="width: 15%">{{ __('Created at') }}</th>
								<th class="text-center" style="width: 1%"></th>
							</tr>
						</thead>
						<tbody>
							@forelse($users as $user)
								<tr scope="row">
									<td class="text-center">{{ $user->id }}</td>
									<td>{{ $user->name }}</td>
									<td class="text-center">{{ $user->email }}</td>
									<td class="text-center">{{ $user->created_at->format('Y-m-d') }}</td>
									<td class="d-flex">
									<a class="ml-2" href="{{ route('dashboard.users.pass', $user->id) }}"><i class="fa fa-key mr-1" title="{{ __('Password') }}"></i></a>
									<a class="ml-2" href="{{ route('dashboard.users.edit', $user->id) }}"><i class="fa fa-edit mr-1" title="{{ __('Edit') }}"></i></a>
										@if ($user->id != auth()->user()->id)
											<a class="ml-2" href="{{ route('dashboard.users.destroy', $user->id) }}"><i class="fa fa-trash mr-1" title="{{ __('Delete') }}"></i></a>
										@else
											<a href=""><i class="text-secondary ml-2 fa fa-trash mr-1" title="{{ __('Not Available') }}"></i></a>
										@endif
									</td>
								</tr>
							@empty
								<td>no users!</td>
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