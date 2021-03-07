@extends('layouts.backoffice_master')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - {{ __('Invoices') }}</title>
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
					<a href="{{ route('invoices.create') }}" class="collapsed" data-parent="#sidebar">
						<button type="submit" class="btn btn-outline-secondary" title="{{ __('New') }}"><span class="fa fa-plus"></span>&nbsp;&nbsp;{{ __('New') }}</button>
					</a>
				</div>
				<h5 class="card-title">{{ __('Invoices') }}</h5>
				<br>
				<div class="table-responsive">
				<form action="{{ route('invoices.search') }}" method="GET">
						<div class="input-group mb-3">

							<input type="text" class="form-control" placeholder="" aria-describedby="basic-addon2" name="search" id="searchtext">
							<div class="input-group-append">
								<button class="btn btn-light" type="submit" id="search"><i class="fas fa-search"></i> &nbsp;&nbsp;{{ __('Search') }}</button>
							</div>
						</div>
					</form>
					<table class="table">
						<thead>
							<tr>
								<th class="text-center" style="width: 10%">ID</th>
								<th class="text-left" style="width: 20%">{{ __('Name') }}</th>
								<th class="text-left" style="width: 20%">{{ __('Ref') }}</th>
								<th class="text-left" style="width: 20%">{{ __('Date') }}</th>
								<th class="text-left" style="width: 20%">{{ __('Supplier') }}</th>
								<th class="text-center" style="width: 10%"></th>
							</tr>
						</thead>
						<tbody>
							@forelse($invoices as $invoice)
								<tr scope="row">
									<td class="text-center">{{ $invoice->id }}</td>
									<td><a href="{{ route('invoices.show', $invoice->id) }}">{{ $invoice->name }}</a></td>
									<td><a href="{{ route('invoices.show', $invoice->id) }}">{{ $invoice->ref }}</a></td>
									<td><a href="{{ route('invoices.show', $invoice->id) }}">{{ $invoice->date }}</a></td>
									<td><a href="{{ route('suppliers.show', $invoice->supplier->id ) }}">{{ $invoice->supplier->name }}</a></td>
									<td class="d-flex">
										<a class="ml-1" href="{{ route('invoices.edit', $invoice->id) }}"><i class="fa fa-edit mr-1" title="{{ __('Edit') }}"></i></a>
										<a class="ml-1" href="{{ route('invoices.delete', $invoice->id) }}"><i class="fa fa-trash mr-1" title="{{ __('Delete') }}"></i></a>
									</td>
								</tr>
							@empty
								<td>{{ __('No Invoices') }}!</td>
							@endforelse
						</tbody>
						<tfoot>
							<tr ><td colspan="6">	{{ $invoices->links() }}</td></tr>
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
// Pesquisa 
var input = document.getElementById("searchtext");
input.addEventListener("keyup", function(event) {

	if (event.keyCode === 13) {
		event.preventDefault();
		document.getElementById("search").click();
	}
});

</script>

@endsection