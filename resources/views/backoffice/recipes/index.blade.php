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
					<a href="{{ route('recipes.create') }}" class="collapsed" data-parent="#sidebar">
						<button type="submit" class="btn btn-outline-secondary" title="{{ __('New recipe') }}"><span class="fa fa-plus"></span>&nbsp;&nbsp;{{ __('New') }}</button>
					</a>
				</div>
				<h5 class="card-title">{{ __('Recipes') }}</h5>
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
							@forelse($recipes as $recipe)
								<tr scope="row">
									<td class="text-left text-nowrap">{{ $recipe->title }}</td>
									<td class="text-center text-nowrap">
										<a class="ml-2" href="{{ route('recipes.pathologies', $recipe->id) }}">
											<i class="fas fa-book-medical mr-1" title="{{ __('Pathologies') }}">
											</i>
										</a>
										{{--<a class="ml-2" href="{{ route('recipes.edit', $recipe->id) }}">
											<i class="fa fa-edit mr-1" title="{{ __('Edit') }}">
											</i>
										</a>
										 <a class="ml-2" href="{{ route('recipes.destroy', $recipe->id) }}">
											<i class="fa fa-trash mr-1" title="{{ __('Delete') }}">
											</i>
										</a> --}}
									</td>
								</tr>
							@empty
								<td colspan="2">{{__('There are no recipes in the system!')}}</td>
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