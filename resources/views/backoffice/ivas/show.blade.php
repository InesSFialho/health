{{-- {{dd($records[0]->totals($year, $trimester, 0))}} --}}

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
                        <h5 class="card-title text-center">{{$trimester}}º TRIMESTRE DE {{$year}} </h5>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12">
                        <h6 class="card-title"><strong>A favor do estado </strong></h6>
                        <hr>
                        @foreach ($records[0]->details_by_trimester($year, $trimester, 1) as $key => $val)
                        <h5 class="card-title"><strong>{{date('F', mktime(0, 0, 0, $key, 10))}} {{$year}}</strong></h5>
                        <table class="table-sm table-striped table-responsive">
                            <thead>
                                <tr>
                                    <td style="width: 20%" class="text-nowrap">{{ __('Supplier') }}</td>
                                    <td style="width: 25%" class="text-nowrap">{{ __('Invoice') }}</td>
                                    <td style="width: 15%" class="text-nowrap">{{ __('Date') }}</td>
                                    <td style="width: 15%" class="text-right text-nowrap">{{ __('Value') }}</td>
                                    <td style="width: 5%" class="pr-5 pl-5 text-nowrap">{{ __('IVA') }}</td>
                                    <td style="width: 15%" class="text-right text-nowrap">{{ __('Value of IVA') }}</td>
                                    <td style="width: 15%" class="text-right text-nowrap">
                                        {{ __('Value with IVA') }}
                                    </td>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($val as $k => $v)
                                <tr>
                                    <td scope="row" class="text-nowrap">{{$v->supplier}}</td>
                                    <td scope="row" class="text-nowrap">{{$v->invoice}}</td>
                                    <td scope="row" class="text-nowrap">{{$v->date}}</td>
                                    <td scope="row" class="text-right">{{number_format($v->applied_price,2)}}&nbsp;€
                                    </td>
                                    <td scope="row" class="pr-5 pl-5 text-nowrap">{{number_format($v->value)}}%</td>
                                    <td scope="row" class="text-right text-nowrap">
                                        {{number_format((($v->value * $v->applied_price / 100)),2)}}&nbsp;€
                                    </td>
                                    <td scope="row" class="text-right text-nowrap">
                                        {{number_format((($v->value * $v->applied_price / 100)+$v->applied_price ),2)}}&nbsp;€
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                            </tfoot>
                        </table>
                        <br>
                        @endforeach
                        <table class="table table-success">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        Total Valor Aplicado:&nbsp;
                                        {{number_format($records[0]->totals($year, $trimester, 1)['total_applied_price'],2)}}&nbsp;€
                                    </th>
                                    <th></th>
                                    <th class="text-center">
                                        Total Valor IVA:&nbsp;
                                        {{number_format($records[0]->totals($year, $trimester, 1)['total_iva_value'],2)}}&nbsp;€
                                    </th>
                                    <th class="text-center">
                                        Total Valor C/ IVA:&nbsp;
                                        {{number_format($records[0]->totals($year, $trimester, 1)['total_price_with_iva'],2)}}&nbsp;€
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <div class="row">
                    <div class="col-12">
                        <h6 class="card-title"><strong>A favor da empresa </strong></h6>
                        <hr>
                        @foreach ($records[0]->details_by_trimester($year, $trimester, 0) as $key => $val)
                        <h5 class="card-title"><strong>{{date('F', mktime(0, 0, 0, $key, 10))}} {{$year}}</strong></h5>
                        <table class="table-sm table-striped table-responsive">
                            <thead>
                                <tr>
                                    <td style="width: 20%" class="text-nowrap">{{ __('Supplier') }}</td>
                                    <td style="width: 25%" class="text-nowrap">{{ __('Invoice') }}</td>
                                    <td style="width: 15%" class="text-nowrap">{{ __('Date') }}</td>
                                    <td style="width: 15%" class="text-right text-nowrap">{{ __('Value') }}</td>
                                    <td style="width: 5%" class="pr-5 pl-5 text-nowrap">{{ __('IVA') }}</td>
                                    <td style="width: 15%" class="text-right text-nowrap">{{ __('Value of IVA') }}</td>
                                    <td style="width: 15%" class="text-right text-nowrap">
                                        {{ __('Value with IVA') }}
                                    </td>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($val as $k => $v)
                                <tr>
                                    <td scope="row" class="text-nowrap">{{$v->supplier}}</td>
                                    <td scope="row" class="text-nowrap">{{$v->invoice}}</td>
                                    <td scope="row" class="text-nowrap">{{$v->date}}</td>
                                    <td scope="row" class="text-right text-nowrap">
                                        {{number_format($v->applied_price,2)}}&nbsp;€</td>
                                    <td scope="row" class="pr-5 pl-5 text-nowrap">{{number_format($v->value)}}%</td>
                                    <td scope="row" class="text-right text-nowrap">
                                        {{number_format((($v->value * $v->applied_price / 100)),2)}}&nbsp;€
                                    </td>
                                    <td scope="row" class="text-right text-nowrap">
                                        {{number_format((($v->value * $v->applied_price / 100)+$v->applied_price ),2)}}&nbsp;€
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                            </tfoot>
                        </table>
                        <br>
                        @endforeach
                        <table class="table table-success">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        Total Valor Aplicado:&nbsp;
                                        {{number_format($records[0]->totals($year, $trimester, 0)['total_applied_price'],2)}}&nbsp;€
                                    </th>
                                    <th></th>
                                    <th class="text-center">
                                        Total Valor IVA:&nbsp;
                                        {{number_format($records[0]->totals($year, $trimester, 0)['total_iva_value'],2)}}&nbsp;€
                                    </th>
                                    <th class="text-center">
                                        Total Valor C/ IVA:&nbsp;
                                        {{number_format($records[0]->totals($year, $trimester, 0)['total_price_with_iva'],2)}}&nbsp;€
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <br><br><br>
                <a class="btn btn-outline-secondary" href="{{ route('ivas.index') }}">
                    <span class="fa fa-arrow-left"></span>
                    &nbsp;{{ __('Back') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('foot-scripts')
{{-- expr --}}
@endsection
