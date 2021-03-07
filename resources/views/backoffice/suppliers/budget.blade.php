@extends('layouts.backoffice_master')

@section('head-meta')
	<title>{{ str_replace('.', ' ', config('app.name')) }} - {{ __('Edit') }}</title>
@endsection

@section('head-scripts')
	{{-- expr --}}
@endsection

@section('content')
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">{{ __('Budgets') }}&nbsp;{{ $work->name }}</h5>
					<form action="{{ route('invoice_line.update', $supplier_id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="invoice_line_id" value={{$line_id}}>
                        <div class="modal-body">
                            <select class="selectpicker form-control" name="budget_line_id">
                                @foreach ($work->budgets() as $budget)
                                <option value="{{$budget->id}}">
                                    {{$budget->ref}}:&nbsp;{{$budget->product}} - {{number_format($budget->applied_price_according_ivadevido(),2)}}&nbsp;€
                                </option>
                                @endforeach
                                <option value="">
                                    Nenhum
                                </option>
                            </select>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary float-right">{{ __('Save') }}</button>
                        <a class="btn btn-outline-secondary" href="{{ route('suppliers.balancedetails', $supplier_id ) }}">
                            <span class="fa fa-arrow-left"></span>&nbsp; {{ __('Back') }}
                        </a>
                    </form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('foot-scripts')
	{{-- expr --}}
@endsection