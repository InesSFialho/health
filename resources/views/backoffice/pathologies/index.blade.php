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
					<a href="{{ route('pathologies.create') }}" class="collapsed" data-parent="#sidebar">
						<button type="submit" class="btn btn-outline-secondary" title="{{ __('New pathology') }}"><span class="fa fa-plus"></span>&nbsp;&nbsp;{{ __('New') }}</button>
					</a>
				</div>
				<h5 class="card-title">{{ __('Pathologies') }}</h5>
				<br>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th class="text-left text-nowrap" style="width: 90%">{{ __('Title') }}</th>
								<th class="text-center text-nowrap" style="width: 10%">{{ __('Options') }}</th>
							</tr>
						</thead>
						<tbody>
							@forelse($pathologies as $pathology)
								<tr scope="row">
									<td class="text-left text-nowrap">{{ $pathology->name }}</td>
									<td class="text-center text-nowrap">
										{{--<a class="ml-2" href="{{ route('pathologies.edit', $pathology->id) }}">
											<i class="fa fa-edit mr-1" title="{{ __('Edit') }}">
											</i>
										</a>
										 <a class="ml-2" href="{{ route('pathologies.destroy', $pathology->id) }}">
											<i class="fa fa-trash mr-1" title="{{ __('Delete') }}">
											</i>
										</a> --}}
									</td>
								</tr>
							@empty
								<td colspan="2">{{__('There are no pathologies in the system!')}}</td>
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