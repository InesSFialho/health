@extends('layouts.backoffice_master')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - {{ __('Show') }}</title>
@endsection

@section('head-scripts')
{{-- expr --}}
@endsection

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ __('Show') }} </h5>
                @csrf
                @method('PUT')
                <label>{{ __('Name') }}: <strong>{{ $supplier->name }}</strong></label>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card-counter primary">
                            <a href="{{ route('suppliers.balancedetails', $supplier->id ) }}">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <span class="count-numbers">
                                    {{-- {{number_format($supplier->current_account_lines_total() - $invoice_payments,2)}}&nbsp;€ --}}
                                </span>
                                <span class="count-name">{{ __('Current Account') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-counter primary">
                            <a href="{{ route('suppliers.payments', $supplier->id ) }}">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <span class="count-numbers">
                                    {{$supplier->total_payments()}}&nbsp;€
                                </span>
                                <span class="count-name">{{ __('Payments') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                <br><br><br>
                <a class="btn btn-outline-secondary " href="{{ route('suppliers.index') }}">
                    <i class="fas fa-angle-left"></i>&nbsp;&nbsp;{!! __('Back') !!}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('foot-scripts')
{{-- expr --}}
@endsection
