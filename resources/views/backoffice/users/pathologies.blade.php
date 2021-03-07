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
				<h5 class="card-title">{{__('My Health')}}</h5>
				<br>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th class="text-center"></th>
								<th class="text-left text-nowrap" style="width: 90%">{{ __('Pathologies') }}</th>
							</tr>
						</thead>
						<tbody>
							@forelse($user->pathologies() as $pathology)
								<tr scope="row">
									<td class="text-center">
										<form action="{{ route('user.health.update', [$user->id, $pathology->id]) }}" method="POST">
											@csrf
											@method('PUT')
											@if ($pathology->have)
											<a href="#" onclick="$(this).closest('form').submit()">
												<i class="text-info far fa-check-square"></i>
											</a>
											@else
											<a href="#" onclick="$(this).closest('form').submit()">
												<i class="text-info far fa-square"></i>
											</a>
											@endif
										</form>
									</td>
									<td class="text-left text-nowrap">{{ $pathology->name }}</td>
								</tr>
							@empty
								<td></td>	
								<td>{{__('There are no pathologies in the system!')}}</td>
							@endforelse
						</tbody>
					</table>
				</div>
				<br><br>
				<a class="btn btn-outline-secondary" href="{{ route('recipes.index') }}"><span class="fa fa-arrow-left"></span>&nbsp; {{ __('Back') }}</a>
			</div>
		</div>
	</div>
</div>
@endsection

@section('foot-scripts')
@endsection