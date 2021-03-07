@extends('layouts.backoffice_master')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - {{ __('ivas') }}</title>
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
                <h5 class="card-title">{{ __('Ivas') }}</h5>
                <br>

                @forelse ($records[0]->years() as $invoice)
                <h6 class="card-title">{{ $invoice->year }}</h6>
                <hr>

                <div class="row">
                    <div class="col-md-3">
                        <div class="card-counter danger">
                            <a href="{{ route('ivas.show', ['year' => $invoice->year, 'trimester' => 1]) }}">
                                <i class="fas fa-landmark"></i>
                                <span class="count-numbers">
                                    {{number_format($records[0]->totals($invoice->year, 1, 1)['total_iva_value'],2)}}&nbsp;€
                                </span>
                                <span class="count-name">{{ __('1st Trimester') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card-counter danger">
                            <a href="{{ route('ivas.show', ['year' => $invoice->year, 'trimester' => 2]) }}">
                                <i class="fas fa-landmark"></i>
                                <span class="count-numbers">
                                    {{number_format($records[0]->totals($invoice->year, 2, 1)['total_iva_value'],2)}}&nbsp;€
                                </span>
                                <span class="count-name">{{ __('2nd Trimester') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card-counter danger">
                            <a href="{{ route('ivas.show', ['year' => $invoice->year, 'trimester' => 3]) }}">
                                <i class="fas fa-landmark"></i>
                                <span class="count-numbers">
                                    {{number_format($records[0]->totals($invoice->year, 3, 1)['total_iva_value'],2)}}&nbsp;€
                                </span>
                                <span class="count-name">{{ __('3rd Trimester') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card-counter danger">
                            <a href="{{ route('ivas.show', ['year' => $invoice->year, 'trimester' => 4]) }}">
                                <i class="fas fa-landmark"></i>
                                <span class="count-numbers">
                                    {{number_format($records[0]->totals($invoice->year, 4, 1)['total_iva_value'],2)}}&nbsp;€
                                </span>
                                <span class="count-name">{{ __('4th Trimester') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <br>
                @empty
                <p>No records!</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
</div>



@endsection

@section('foot-scripts')


<script>
    var input = document.getElementById("searchtext");

    input.addEventListener("keyup", function (event) {

        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("search").click();
        }
    });

</script>
@endsection
