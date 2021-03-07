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
            <form action="{{ route('invoices.addLine', $invoice->id) }}" method="POST">
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
                    <input type="checkbox" class="form-control" name="outros">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add Payment-->
<div class="modal fade" id="addPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Payment') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('invoices.addPayment', $invoice->id) }}" method="POST">
                @csrf
                <div class="modal-body">

                    <label>{{ __('Value') }}</label>
                    <input type="number" class="form-control" step=".001" name="value"><br>

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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Document') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('invoices.addDoc', $invoice->id) }}" method="POST" enctype="multipart/form-data">
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


<!-- Modal Edit Payment-->
<div class="modal fade" id="editPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{ __('Edit Payment') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('invoices.updatePayment') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="number" name="payment_id" id="payment_id" hidden><br>
                    <label>{{ __('Value') }}</label>
                    <input type="number" class="form-control" step=".01" value="" name="payment_value" id="payment_value"><br>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal edit Invoice Line-->
<div class="modal fade" id="edit_invoice_line" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Line') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('invoices.updateLine') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="number" name="line_id" id="line_id" hidden><br>
                    <label>{{ __('Tipo') }}</label>
                    <select class="selectpicker form-control" name="producttype" id="line_producttype_id">
                        @foreach ($producttypes as $producttype)
                        <option value="{{ $producttype->id }}">{{ $producttype->name }}</option>
                        @endforeach
                    </select><br><br>
                    <label>{{ __('Works') }}</label>
                    <select class="selectpicker form-control" name="work" id="work_id">
                        @foreach ($works as $work)
                        <option value="{{ $work->id }}">{{ $work->name }}</option>
                        @endforeach
                    </select><br><br>
                    <label>{{ __('Value') }}</label>
                    <input type="number" class="form-control" step=".01" name="value" id="line_applied_price"><br>
                    <label>{{ __('IVA') }}</label>
                    <select class="selectpicker form-control" name="iva" id="iva_id">
                        @foreach ($ivas as $iva)
                        <option value="{{ $iva->id }}">{{ $iva->name }}</option>
                        @endforeach
                    </select><br><br>
                    <label>{{ __('IVA Devido') }}</label>
                    <input type="checkbox" class="form-control" name="ivaDevido"  id="ivadevido"><br>
                    <label>{{ __('Outros') }}</label>
                    <input type="checkbox" class="form-control" name="outros"  id="outros">
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
                <h5 class="card-title">{{ $invoice->name }}</h5>
                <hr>
                <div class="row">

                    <div class="col-4">
                        <label>{{ __('Supplier') }}</label><br>
                        <strong>@if(isset($supplier->name)){{ $supplier->name }}@endif</strong>
                    </div>
                    <div class="col-4">
                        <label>{{ __('Ref') }}</label><br>
                        <strong>{{ $invoice->ref }}</strong>
                    </div>
                    <div class="col-4">
                        <label>{{ __('Date') }}</label><br>
                        <strong>{{ $invoice->date }}</strong>
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
                                        <th class="text-right" style="width: 10%">{{ __('Value') }}</th>
                                        <th class="text-center" style="width: 10%">{{ __('IVA') }}</th>
                                        <th class="text-right" style="width: 10%">{{ __('Value with IVA') }}</th>
                                        <th class="text-center" style="width: 10%">{{ __('IVA Devido') }}</th>
                                        <th class="text-center" style="width: 5%">{{ __('Outros') }}</th>
                                        <th class="text-center" style="width: 10%">{{ __('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($invoice->lines() !== null)
                                    @foreach($invoice->invoice_lines() as $invoice_line)
                                    <tr>
                                        <td>{{$invoice_line->producttype->name }}</td>
                                        <td>{{$invoice_line->work->name }}</td>
                                        <td class="text-right pr-3">{{number_format($invoice_line->applied_price, 2)}}&nbsp;€</td>
                                        <td class="text-center">{{ $invoice_line->iva->value }}</td>
                                        <td class="text-right pr-3">
                                            {{number_format($invoice_line->applied_price_with_iva(), 2)}}&nbsp;€
                                        </td>
                                        <td class="text-center">@if($invoice_line->ivadevido === 1)<i class="far fa-check-square"></i>@else <i class="far fa-square"></i>
                                            @endif</td>
                                        <td class="text-center">@if($invoice_line->outros === 1)<i class="far fa-check-square"></i>@else <i class="far fa-square"></i>
                                            @endif</td>
                                        <td class="text-center">
                                            <a data-target="#edit_invoice_line" data-toggle="modal" class="ml-1 edit_invoice_line" href="" id="edit_invoice_line" data-id="{{$invoice_line->id}}" data-producttype_id="{{$invoice_line->producttype_id}}"  data-producttype="{{$invoice_line->producttype}}" data-work_id="{{$invoice_line->work_id}}"  data-applied_price="{{$invoice_line->applied_price}}"  data-iva_id="{{$invoice_line->iva_id}}"  data-ivadevido="{{$invoice_line->ivadevido}}"  data-outros="{{$invoice_line->outros}}">
                                                <i class="fa fa-edit mr-1" title="{{ __('Edit') }}"></i>
                                            </a>
                                            <a class="ml-1" href="{{ route('invoices.delLine', $invoice_line->id) }}"><i class="fa fa-trash mr-1" title="{{ __('Delete') }}"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
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

                        <h5 class="card-title">{{ __('Payments') }}</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-left">{{ __('Product') }}</th>
                                        <th scope="col" class="text-right">{{ __('Line Value') }}</th>
                                        <th scope="col" class="text-center">{{ __('Payment Date') }}</th>
                                        <th scope="col" class="text-right">{{ __('Payment') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($invoice->payments() as $payment)
                                    <tr>
                                        <td class="text-left">
                                            {{$payment->product}}
                                        </td>
                                        <td class="text-right">
                                            {{number_format($payment->applied_price_with_iva, 2)}}&nbsp;€
                                        </td>
                                        <td class="text-center">
                                            {{$payment->date}}
                                        </td>
                                        <td class="text-right">
                                            {{number_format($payment->value,2)}}&nbsp;€
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3">
                                            {{ __('No payments on selected date!') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4"></th>
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

                        <h5 class="card-title">{{ __('Documents') }}</h5>

                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('Document Type') }}</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('User') }}</th>
                                        <th>{{ __('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($invoice->docs as $invoice_doc)

                                    <tr>
                                        <td>{{$invoice_doc->docname}}</td>
                                        <td>{{$invoice_doc->created_at}}</td>
                                        <td>{{$invoice_doc->username}}</td>
                                        <td>{{$invoice_doc->note}}</td>
                                        <td><a class="ml-1" href="{{url('/')}}/{{ $invoice_doc->path  }}" target="_blank"><i class="fa fa-download mr-1" title="{{ __('Download') }}"></i></a>
                                            <a class="ml-1" href="{{ route('invoices.delDoc', $invoice_doc->id) }}"><i class="fa fa-trash mr-1" title="{{ __('Delete') }}"></i></a>
                                        </td>
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

                        <br><br>
                        <a class="btn btn-outline-secondary" href="{!! URL::previous() !!}"><span class="fa fa-arrow-left"></span>&nbsp; {{ __('Back') }}</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('foot-scripts')



<script>
    $(document).on("click", ".edit_payment", function() {

        var payment_id = $(this).data('id');
        var payment_value = $(this).data('value');

        document.getElementById("payment_id").value = payment_id;
        document.getElementById("payment_value").value = payment_value;

    });


    $(".edit_invoice_line").click(function(e) {

        var line_id = $(this).data('id');
        var line_producttype_id = $(this).data('producttype_id');
        var line_producttype = $(this).data('producttype');
       
        var work_id = $(this).data('work_id');
        var iva_id = $(this).data('iva_id');
        var applied_price = $(this).data('applied_price');
        var ivadevido = $(this).data('ivadevido');
        var outros = $(this).data('outros');

        document.getElementById("line_id").value = line_id;  

        document.getElementById("line_producttype_id").value = line_producttype_id;       
        $('#line_producttype_id').selectpicker('refresh');

        document.getElementById("work_id").value = work_id;
        $('#work_id').selectpicker('refresh');
        
        document.getElementById("iva_id").value = iva_id;
        $('#iva_id').selectpicker('refresh');
        
        document.getElementById("line_applied_price").value = applied_price;

        if(ivadevido == 1){
            document.getElementById("ivadevido").checked = true;;
        } else{
            document.getElementById("ivadevido").checked = false;;
        }
        if(outros == 1){
            document.getElementById("outros").checked = true;;
        } else{
            document.getElementById("outros").checked = false;;
        }

    });
</script>
@endsection