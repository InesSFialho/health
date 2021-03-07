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
                        <div class="card-counter light">
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
                        <div class="card-counter primary">
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
                        @php
                            $unbilled_budget_total = 0;
                        @endphp
                        @if(!$work->unbilled_budget_lines($category->id)->isEmpty())
                        <h6 class="card-title"><strong>{{ $category->name }} </strong></h6>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 50%" class="text-left">{{ __('Type') }}</th>
                                    <th scope="col" style="width: 50%" class="text-right">{{ __('Value with IVA') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($work->unbilled_budget_lines($category->id) as $line)
                                <tr>
                                    <td class="text-left">
                                        {{$line->producttype}}
                                    </td>
                                    <td class="text-right">
                                        {{number_format($line->applied_price_with_iva, 2)}}&nbsp;€  
                                    </td>
                                </tr>
                                @php
                                    $unbilled_budget_total += $line->applied_price_with_iva;
                                @endphp
                                @endforeach
                            </tbody>
                            <tfoot class="table-success">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col" class="text-right">{{number_format($unbilled_budget_total, 2)}}&nbsp;€</th>
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
