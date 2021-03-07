@extends('layouts.backoffice_master')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} </title>
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
                        <h5 class="card-title">{{ __('Work') }} </h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label>{{ __('Name') }}: <strong>{{ $work->name }}</strong></label>
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card-counter light">
                            <a href="{{ route('works.comparation', $work->id ) }}">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <span class="count-numbers">{{ number_format($work->comparation_total(),2) }}&nbsp;€</span>
                                <span class="count-name">{{ __('Expected Cost') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card-counter light">
                            <a href="{{ route('works.show', $work->id ) }}">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <span class="count-numbers">{{ number_format($work->total(),2) }}&nbsp;€</span>
                                <span class="count-name">{{ __('Custo Total') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card-counter light">
                            <a href="{{ route('works.real', $work->id ) }}">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <span class="count-numbers">{{ number_format($work->real_total(),2) }}&nbsp;€</span>
                                <span class="count-name">{{ __('Custo Real Total') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card-counter primary">
                            <a href="{{ route('works.budget', $work->id ) }}">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <span class="count-numbers">{{ number_format($work->budget_total(),2) }}&nbsp;€</span>
                                <span class="count-name">{{ __('Budget') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card-counter light">
                            <a href="{{ route('works.payed', $work->id ) }}">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <span class="count-numbers">{{number_format($work->total_already_payed(),2)}}&nbsp;€</span>
                                <span class="count-name">{{ __('Payments') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card-counter light">
                            <a href="{{ route('works.to-pay', $work->id ) }}">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <span class="count-numbers">{{ number_format($work->total_in_debt(),2) }}&nbsp;€</span>
                                <span class="count-name">{{ __('Por Pagar') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card-counter light">
                            <a href="{{ route('works.out-of-budget', $work->id ) }}">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <span class="count-numbers">{{ number_format($work->total_out_of_budget(),2) }}&nbsp;€</span>
                                <span class="count-name">{{ __('Value Out Of Budget') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card-counter light">
                            <a href="{{ route('works.unbilled-budget', $work->id ) }}">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <span class="count-numbers">{{ number_format($work->total_unbilled_budget(),2) }}&nbsp;€</span>
                                <span class="count-name">{{ __('Unbilled Budget') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <div class="row">
                    <div class="col">

                        @foreach($categories as $category)
                        @if($work->budget_lines_count($category->id, $work->id) > 0)
                        <h6 class="card-title"><strong>{{ $category->name }} </strong></h6>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 25%">{{ __('Type') }}</th>
                                    <th scope="col" style="width: 25%">{{ __('Supplier') }}</th>
                                    <th scope="col" style="width: 20%">{{ __('Budget') }}</th>
                                    <th scope="col" class="text-right text-nowrap" style="width: 15%">{{ __('Billed Value w/ IVA') }}</th>
                                    <th scope="col" class="text-right text-nowrap" style="width: 15%">{{ __('Value with IVA') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($work->budget_lines($category->id, $work->id) as $budgetline)
                                <tr>
                                    <td class="text-nowrap" scope="row">{{$budgetline->producttype}}</td>
                                    <td class="text-nowrap"><a
                                            href="{{ route('suppliers.show', $budgetline->supplier_id) }}">{{$budgetline->supplier}}</a>
                                    </td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('budgets.show', $budgetline->budget_id) }}">{{$budgetline->budget}}</a>
                                    </td>
                                    <td class="text-nowrap text-right">{{$budgetline->invoice_line == null ? '-' : number_format($budgetline->invoice_line->applied_price_with_iva(), 2)}}&nbsp;€</td>
                                    <td class="text-nowrap text-right">
                                        {{number_format((float)$budgetline->budget_with_iva(), 2)}}&nbsp;€
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-success">
                                <tr>
                                    <td class="text-right" colspan="5">
                                        <strong>
                                            {{number_format($work->total_budget_by_category($category->id),2)}}&nbsp;€
                                        </strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        @endif
                        @endforeach
                    </div>
                </div>
                <br><br><br>
                <a class="btn btn-outline-secondary" href="{{ route('works.index') }}">
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
