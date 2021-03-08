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
					<a href="{{ route('clinical-examination-questions.create') }}" class="collapsed" data-parent="#sidebar">
						<button type="submit" class="btn btn-outline-secondary" title="{{ __('New Clinical Examination Question') }}"><span class="fa fa-plus"></span>&nbsp;&nbsp;{{ __('New') }}</button>
					</a>
				</div>
				<h5 class="card-title">{{ __('Clinical Examination Questions') }}</h5>
				<br>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th class="text-left text-nowrap" style="width: 50%">{{ __('Questions') }}</th>
								<th class="text-center text-nowrap" style="width: 40%">{{ __('Possible Choices') }}</th>
								<th class="text-center text-nowrap" style="width: 10%"></th>
							</tr>
						</thead>
						<tbody>
							@forelse($questions as $question)
								<tr scope="row">
									<td class="text-left text-nowrap">{{ $question->question }}</td>
									<td class="text-center">
										@forelse ($question->options() as $option)
										{{$option->name}};
										@empty
										{{__('No options')}}
										@endforelse
									</td>
									<td class="text-center text-nowrap">
										<a class="ml-2" href="{{ route('clinical-examination-questions.options.index', $question->id) }}">
											<i class="fa fa-list-ul mr-1" title="{{ __('Edit Options') }}">
											</i>
										</a>
										{{--<a class="ml-2" href="{{ route('clinical-examination-questions.edit', $question->id) }}">
											<i class="fa fa-edit mr-1" title="{{ __('Edit') }}">
											</i>
										</a>
										 <a class="ml-2" href="{{ route('clinical-examination-questions.destroy', $question->id) }}">
											<i class="fa fa-trash mr-1" title="{{ __('Delete') }}">
											</i>
										</a> --}}
									</td>
								</tr>
							@empty
								<td colspan="2">{{__('There are no clinical examination questions in the system!')}}</td>
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