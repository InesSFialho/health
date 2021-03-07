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
                <div class="row">
                    <div class="col">
                        <h5 class="card-title">
                            {{ __('Payments of') }}&nbsp;<strong>{{ $request->date }}</strong>
                        </h5>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-nowrap">{{ __('Invoice') }}</th>
                                        <th scope="col" class="text-center text-nowrap">{{ __('Product') }}</th>
                                        <th scope="col" class="text-right text-nowrap">{{ __('Line Value') }}</th>
                                        <th scope="col" class="text-right text-nowrap">{{ __('Payment') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_payments = 0;
                                    @endphp
                                    @forelse($supplier->paymentsByDate($request->date) as $payment)
                                    <tr>
                                        <td class="text-nowrap">
                                            {{$payment->invoice}}
                                        </td>
                                        <td class="text-center text-nowrap">
                                            {{$payment->product}}
                                        </td>
                                        <td class="text-right text-nowrap">
                                            {{number_format($payment->invoice_line->applied_price_with_iva(), 2)}}&nbsp;€
                                        </td>
                                        <td class="text-right text-nowrap">
                                            {{number_format($payment->value,2)}}&nbsp;€
                                        </td>
                                    </tr>
                                    @php
                                        $total_payments += (float)$payment->value;
                                    @endphp
                                    @empty
                                    <tr>
                                        <td colspan="4">
                                            {{ __('No payments on selected date!') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                @if ($total_payments)
                                <tfoot class="table-info">
                                    <tr>
                                        <th colspan="3"></th>
                                        <th class="text-right">{{number_format($total_payments,2)}}&nbsp;€</th>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
                <br><br>
                <a class="btn btn-outline-secondary" href="{!! URL::previous() !!}">
                    <span class="fa fa-arrow-left"></span>&nbsp;{{ __('Back') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('foot-scripts')
{{-- expr --}}
@endsection
