@extends('layouts.backoffice_master')

@section('head-meta')


<title>{{ str_replace('.', ' ', config('app.name')) }} - {{ __('Edit') }}</title>
@endsection

@section('head-scripts')
{{-- expr --}}
@endsection

@section('content')
<!-- Modal Add Payment-->
<div class="modal fade" tabindex="-1" role="dialog" id="paymentModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{ __('Add Payment') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="paymentForm" action="{{ route('payments.store') }}" method="POST">
				@csrf
				<div class="modal-body">
                    <input id="invoice_line_id" type="hidden" name="invoice_line_id">
					<label>{{ __('Value') }}</label>
					<input type="number" class="form-control" name="value" step="0.01" min="0.01" required>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="float-right">
                    <form action="{{ route('suppliers.payments', $supplier->id) }}" method="GET">
                    @csrf
                    <div class="d-flex">
                        <input type="text" class="form-control input-sm" id="datepicker" name="date" required>
                        <button class="btn btn-sm btn-light text-nowrap ml-1 border-secondary" type="submit">
                            {{ __('See payments by date') }}
                        </button>
                    </div>
                    </form>
                </div>
                <br><br><br><br>
                <div class="row">
                    <div class="col">
                        <h4 class="card-title text-center">{{__('Current Account')}}<strong>&nbsp;{{$supplier->name}}</strong></h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <table class="table table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 10%" class="text-center align-middle text-nowrap">{{__('Line')}}</th>
                                    <th scope="col" style="width: 30%" class="text-left align-middle text-nowrap">{{__('Work')}}</th>
                                    <th scope="col" style="width: 10%" class="text-center align-middle text-nowrap">{{__('Invoice')}}</th>
                                    <th scope="col" style="width: 15%" class="text-right align-middle text-nowrap">{{__('Invoice Line Value')}}</th>
                                    <th scope="col" style="width: 10%" class="text-center align-middle text-nowrap">{{__('Budget')}}</th>
                                    <th scope="col" style="width: 15%" class="text-right align-middle text-nowrap">{{__('Budget Line Value')}}</th>
                                    <th scope="col" style="width: 15%" class="text-right align-middle text-nowrap">{{__('Payed')}}</th>
                                    <th scope="col" style="width: 15%" class="text-center align-middle text-nowrap">{{__('In Debt')}}</th>
                                    <th scope="col" style="width: 15%" class="text-center align-middle text-nowrap">{{__('Options')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_invoice_lines = 0;
                                    $total_billed_budget = 0;
                                    $total_payments = 0;
                                    $total_in_dept = 0;
                                @endphp
                                @foreach($supplier->supplier_invoices() as $invoice)
                                @foreach($invoice->invoice_lines() as $line)
                                <tr>
                                    <td class="text-center align-middle text-nowrap">{{sprintf("%08d",  $line->id)}}</td>
                                    <td class="text-left align-middle text-nowrap"> {{$line->work->name}}</td>
                                    <td class="text-center align-middle text-nowrap">
                                        <a href="{{ route('invoices.show', $line->invoice->id) }}">{{$line->invoice->name}}</a>
                                    </td>
                                    <td class="text-right align-middle text-nowrap">
                                        {{number_format((float)$line->applied_price_according_ivadevido(),2)}}&nbsp;€
                                        {{$line->ivadevido ? '*' : ''}}
                                    </td>
                                    <td class="text-center align-middle text-nowrap" class="text-right">
                                        {{$line->budget_line_id == null ? "-" : $line->budget()}}
                                     </td>
                                    <td class="text-right align-middle" class="text-right">
                                       {{$line->budget_line_id == null ? "0.00" : number_format($line->budget_line->applied_price_according_ivadevido(),2)}}&nbsp;€
                                       {{$line->budget_line['ivadevido'] ? '*' : ''}}
                                    </td>
                                    <td class="text-right align-middle text-nowrap" class="text-right">{{number_format($line->total_payments(),2)}}&nbsp;€</td>
                                    <td class="text-right align-middle text-nowrap">
                                        {{number_format(($line->applied_price_according_ivadevido()-$line->total_payments()),2)}}&nbsp;€
                                    </td>
                                    <td class="text-center align-middle text-nowrap">
                                        <button id="paymentBtn" class="btn btn-outline-light text-primary border-0 p-0" data-id="{{$line->id}}">
                                            <span class="fas fa-euro-sign" title="{{ __('Add Payment') }}"></span>
                                        </button>
                                        <a href="{{route('invoice_line.edit', [$supplier->id, $line->id, $line->work->id])}}" class="text-primary">
                                            <span class="fas fa-file-alt" title="{{ __('Link Budget') }}"></span>
                                        </a>
									</td>
                                </tr>
                                @php
                                    $total_invoice_lines += (float)$line->applied_price_according_ivadevido();
                                    $total_billed_budget += ($line->budget_line_id == null) ? 0 : (float)$line->budget_line->applied_price_according_ivadevido();
                                    $total_payments += (float)$line->total_payments();
                                    $total_in_dept += $line->applied_price_according_ivadevido()-$line->total_payments();
                                @endphp
                                @endforeach
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-info">
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col" class="text-right">{{number_format($total_invoice_lines,2)}}&nbsp;€</th>
                                    <th scope="col"></th>
                                    <th scope="col" class="text-right">
                                        {{number_format($total_billed_budget,2)}}&nbsp;€
                                    </th>
                                    <th scope="col" class="text-right">
                                        {{number_format($total_payments,2)}}&nbsp;€
                                    </th>
                                    <th scope="col" class="text-right">
                                        {{number_format($total_in_dept,2)}}&nbsp;€
                                    </th>
                                    <th scope="col"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <br><br><br>
                <a class="btn btn-outline-secondary" href="{{ route('suppliers.index') }}"><span
                        class="fa fa-arrow-left"></span>&nbsp; {{ __('Back') }}</a>
            </div>

        </div>
    </div>
</div>
@endsection

@section('foot-scripts')
<script>
$(document).ready(function () {
    $(document).on('click', '#paymentBtn', function() {
        $('#invoice_line_id').val($(this).attr('data-id'));
        $('#paymentModal').modal('show')
    });
});

$('#datepicker').datepicker({
    format: 'yyyy-mm-dd',
    uiLibrary: 'bootstrap4'
});
</script>
@endsection 
