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
                <h5 class="card-title">{{ __('Edit') }} </h5>
                <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label>{{ __('Name') }}</label>
                    <input class="form-control " type="text" name="name" value="{{ $invoice->name }}" maxlength="255"
                        autofocus required>
                    <small class="text-muted fa-pull-right">max. 255</small>
                    <br>
                    <label>{{ __('Ref') }}</label>
                    <input class="form-control" type="text" name="ref" value="{{ $invoice->ref }}" maxlength="255">
                    <br>
                    <label>{{ __('Date') }}</label>
                    <input class="form-control" type="text" name="date" value="{{ $invoice->date }}" id="datepicker">
                    <small class="text-muted fa-pull-right">aaaa-mm-dd</small>
                    <br>
                    <label>{{ __('Supplier') }}</label>
                    <select class="selectpicker form-control" name="supplier">
                        <option value="{{ $invoice->supplier_id }}">
                            @if(isset($supplier->name)){{ $supplier->name }}@endif</option>
                        @forelse ($suppliers as $supplier)
                        @if ($supplier->id != $invoice->supplier_id)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endif
                        @empty
                        {{ __('no suppliers available!') }}
                        @endforelse
                    </select>
                    <br><br>
                    <a class="btn btn-outline-secondary" href="{!! URL::previous() !!}"><span
                            class="fa fa-arrow-left"></span>&nbsp; {{ __('Back') }}</a>

                    <button class="btn btn-outline-secondary " type="submit"><i class="fa fa-save"></i>&nbsp; {!!
                        __('Save') !!}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('foot-scripts')
<script>
    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        uiLibrary: 'bootstrap4'
    });

</script>
@endsection
