@extends('layouts.backoffice_master')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - {{ __('Contacts') }}</title>
<link rel="stylesheet" href="{{URL::asset('css/style.css')}}">
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
						<h5 class="card-title">{{ __('Contacts') }}</h5>
					</div>

					<div class="col-5">
						
					</div>
					<div class="col-2 ">
						<div class="float-right">
						<a href="{{route('backoffice.contacts.create')}}" class="collapsed" data-parent="#sidebar">
						<button type="submit" class="btn btn-outline-secondary"><span class="fa fa-plus"></span>&nbsp;&nbsp;Novo</button>
                </a>
							
						</div>
					</div>

				</div>
				<br>
				<div class="table-responsive ">
					<table class="table table-striped">
						<thead>
							<tr>
								<th scope="col">Ordem</th>
								<th scope="col">Icon</th>
								<th scope="col">Nome</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							@foreach($contacts as $contact)
							<tr scope="row">
								<td>{{ $contact->sort }}</td>
								<td>
								<object class="icon" data="/assets/icons/{{$contact->icon}}.svg" type="image/svg+xml"></object></td>
								<td>{{ $contact->name }}</td>
								<td  class="botoes"><a  href="/backoffice/contacts/edit/{{$contact->id}}"  ><i class="fa fa-edit"></i></a>
									<a  href="/backoffice/contacts/delete/{{$contact->id}}"  onclick="return confirm('Tem a certeza?')" ><i class="fa fa-trash"></i></a></td>
							</tr>
							
							@endforeach

						</tbody>
					</table>
					{!! $contacts->render() !!}
				</div>

			</div>
		</div>
	</div>
</div>



@endsection

@section('foot-scripts')


@endsection