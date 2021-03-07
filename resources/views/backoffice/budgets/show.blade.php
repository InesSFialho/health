@extends('layouts.backoffice_master')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - {{ __('Edit') }}</title>

@endsection

@section('head-scripts')
<!-- Modal Add Line-->
<div class="modal fade" id="addLine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">{{ __('Add Line') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('budgets.addLine', $budget->id ) }}" method="POST">
				@csrf
				<div class="modal-body">
					<label>{{ __('Tipo') }}</label>
					<select class="selectpicker form-control" name="producttype">
						@foreach ($producttypes as $producttype)
						<option value="{{ $producttype->id }}">{{ $producttype->name }}</option>
						@endforeach
					</select><br><br>
					<label>{{ __('Works') }}</label>
					<select class="selectpicker form-control" name="work">
						@foreach ($works as $work)
						<option value="{{ $work->id }}">{{ $work->name }}</option>
						@endforeach
					</select><br><br>
					<label>{{ __('Value') }}</label>
					<input type="number" class="form-control" step=".001" name="value"><br>
					<label>{{ __('IVA') }}</label>
					<select class="selectpicker form-control" name="iva">
						@foreach ($ivas as $iva)
						<option value="{{ $iva->id }}">{{ $iva->name }}</option>
						@endforeach
					</select><br><br>
					<label>{{ __('IVA Devido') }}</label>
					<input type="checkbox" class="form-control" name="ivaDevido"><br>
					<label>{{ __('Outros') }}</label>
					<input type="checkbox" class="form-control" name="ivaDevido">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
					<button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- Modal Add Doc-->
<div class="modal fade" id="addDoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">{{ __('Add Document') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('budgets.addDoc', $budget->id) }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<label>{{ __('Document Type') }}</label>
					<select class="selectpicker form-control" name="documentname_id">
						@foreach ($docnames as $docname)
						<option value="{{ $docname->id }}">{{ $docname->name }}</option>
						@endforeach
					</select><br><br>
					<label>{{ __('Observation') }}</label>
					<input type="text" class="form-control" name="observation"><br>
					<label>{{ __('File') }}</label>
					<input class="form-control" type="file" name="upload_file" id="upload_file">
					<br>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
					<button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">{{ $budget->name }}</h5>
				<hr>
				<div class="row">
					
					<div class="col-4">
						<label>{{ __('Supplier') }}</label><br>
						<strong>@if(isset($supplier->name)){{ $supplier->name }}@endif</strong>
					</div>
					<div class="col-4">
						<label>{{ __('Ref') }}</label><br>
						<strong>{{ $budget->ref }}</strong>
					</div>
					<div class="col-4">
						<label>{{ __('Date') }}</label><br>
						<strong>{{ $budget->date }}</strong>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-sm table-striped ">
						<thead>
							<tr>
							<th style="width: 20%">{{ __('Product Type') }}</th>
							<th style="width: 20%">{{ __('Work') }}</th>
								<th style="width: 10%" class="text-center">{{ __('Value') }}</th>
								<th style="width: 10%" class="text-center">{{ __('IVA') }}</th>
								<th style="width: 10%" class="text-center">{{ __('Value with IVA') }}</th>
								<th style="width: 5%" class="text-center">{{ __('IVA Devido') }}</th>
								<th style="width: 5%" class="text-center">{{ __('Outros') }}</th>
								<th style="width: 10%">{{ __('Options') }}</th>
							</tr>
						</thead>
						<tbody>

							@foreach($budget_lines as $budget_line)
							<tr>
								<td>{{ $budget_line->producttype }}</td>
								<td>{{ $budget_line->work }}</td>
								<td class="text-right pr-3">{{number_format($budget_line->applied_price, 2)}} €</td>
								<td class="text-center">{{ $budget_line->iva }}</td>
								<td class="text-right pr-3">
									{{number_format(($budget_line->applied_price * $budget_line->ivavalue/100 + $budget_line->applied_price),2) }} €
								</td>
								<td class="text-center">@if($budget_line->ivadevido === 1)<i class="far fa-check-square"></i>@else <i class="far fa-square"></i> @endif</td>
								<td class="text-center">@if($budget_line->outros === 1)<i class="far fa-check-square"></i>@else <i class="far fa-square"></i> @endif</td>
								<td><a class="ml-1" href="{{ route('budgets.delLine', $budget_line->id) }}"><i class="fa fa-trash mr-1" title="{{ __('Delete') }}"></i></a></td>
							</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<td colspan="8">
									<button type="button" class="btn  btn-outline-success" data-toggle="modal" data-target="#addLine">
										<strong>{{ __('Add') }}</strong>&nbsp;&nbsp;<i class="fa fa-plus"></i>
									</button>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<div class="form-group">
					<h5 class="card-title">{{ __('Documents') }}</h5>
					<div class="row">
						<div class="table-responsive">
							<table class="table table-sm table-striped">
								<thead>
									<tr>
										<th style="width: 20%">{{ __('Document Type') }}</th>
										<th style="width: 20%">{{ __('Date') }}</th>
										<th style="width: 20%">{{ __('User') }}</th>
										<th style="width: 30%">{{ __('Obs') }}</th>
										<th style="width: 10%">{{ __('Options') }}</th>
									</tr>
								</thead>
								<tbody>

									@foreach($budget_docs as $budget_doc)

									<tr>
										<td>{{$budget_doc->docname}}</td>
										<td>{{$budget_doc->created_at}}</td>
										<td>{{$budget_doc->username}}</td>
										<td>{{$budget_doc->note}}</td>
										<td><a class="ml-1" href="{{url('/')}}/{{ $budget_doc->path  }}" target="_blank"><i class="fa fa-download mr-1" title="{{ __('Download') }}"></i></a>
											<a class="ml-1" href="{{ route('budgets.delDoc', $budget_doc->id) }}"><i class="fa fa-trash mr-1" title="{{ __('Delete') }}"></i></a></td>
									</tr>
									@endforeach

								</tbody>
								<tfoot>
									<tr>
										<td colspan="9">
											<button type="button" class="btn  btn-outline-success" data-toggle="modal" data-target="#addDoc">
												<strong>{{ __('Add') }}</strong>&nbsp;&nbsp;<i class="fa fa-plus"></i>
											</button>

										</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
					<br><br>
					<a class="btn btn-outline-secondary" href="{!! URL::previous() !!}"><span class="fa fa-arrow-left"></span>&nbsp; {{ __('Back') }}</a>

				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('foot-scripts')

@endsection