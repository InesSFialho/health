@extends('layouts.backoffice_master')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - {{ __('Acerca') }}</title>
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
						<h5 class="card-title">{{ __('Acerca') }}</h5>
					</div>

					<div class="col-5">
					
					</div>
					<div class="col-2 ">
						<div class="float-right">
						<a href="{{route('backoffice.abouts.create')}}" class="collapsed" data-parent="#sidebar">
						<button type="submit" class="btn btn-outline-secondary"><span class="fa fa-plus"></span>&nbsp;&nbsp;{{ __('Novo') }}</button>
                </a>
							
						</div>
					</div>

				</div>
				<br>
				<div class="table-responsive ">
					<table class="table table-striped">
						<thead>
							<tr>
							
								<th scope="col">{{ __('Nome') }}</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							@foreach($abouts as $about)
							<tr scope="row">
							
								<td>{{ $about->name }}</td>
								<td  class="botoes"><a  href="/backoffice/abouts/edit/{{$about->id}}"  ><i class="fa fa-edit"></i></a>
									<a  href="/backoffice/abouts/delete/{{$about->id}}"  onclick="return confirm('Tem a certeza?')" ><i class="fa fa-trash"></i></a></td>
							</tr>
							
							@endforeach

						</tbody>
					</table>
					{!! $abouts->render() !!}
				</div>

			</div>
		</div>
	</div>
</div>



@endsection

@section('foot-scripts')


@endsection