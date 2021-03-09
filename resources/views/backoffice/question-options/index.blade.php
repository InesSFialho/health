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
					<a href="{{ route('clinical-examination-questions.options.create', $question->id) }}" class="collapsed" data-parent="#sidebar">
						<button type="submit" class="btn btn-outline-secondary" title="{{ __('New') }}"><span class="fa fa-plus"></span>&nbsp;&nbsp;{{ __('New') }}</button>
					</a>
				</div>
				<h5 class="card-title">{{ $question->question }}</h5>
				<br>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th class="text-left text-nowrap" style="width: 10%">{{ __('Possible Choices') }}</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@forelse($question->options() as $option)
								<tr scope="row">
									<td class="text-left text-nowrap">{{ $option->name }}</td>
									<td class="text-right text-nowrap">
										<form method="post" action="{{ route('clinical-examination-questions.options.destroy', [$question->id, $option->id]) }}">
											@method('DELETE')
											@csrf
											<button class="btn border-none bg-transparent p-0" type="submit"><i class="fa fa-trash mr-1" title="{{ __('Delete') }}"></i></button>
										</form>
									</td>
								</tr>
							@empty
								<td colspan="2">{{__('There are no options for this question!')}}</td>
							@endforelse
						</tbody>
					</table>
				</div>
				<a class="btn btn-outline-secondary" href="{{ route('clinical-examination-questions.index', $question->id) }}"><span class="fa fa-arrow-left"></span>&nbsp; {{ __('Back') }}</a>
			</div>
		</div>
	</div>
</div>
@endsection

@section('foot-scripts')
@endsection