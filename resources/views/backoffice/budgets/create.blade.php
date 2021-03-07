@extends('layouts.backoffice_master')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - {{ __('Budget') }}</title>
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
                <h5 class="card-title">{{ __('New') }}</h5>
                <form action="{{ route('budgets.store') }}" method="POST">
                    @csrf
                    <label>{{ __('Name') }}</label>
                    <input class="form-control" type="text" name="name" maxlength="255" autofocus required>
                    <small class="text-muted fa-pull-right">max. 255</small>
                    <br>
                    <label>{{ __('Ref') }}</label>
                    <input class="form-control" type="text" name="ref" maxlength="255">
                    <br>
                    <label>{{ __('Date') }}</label>
                    <input class="form-control" type="text" name="date" maxlength="255" id="datepicker">
                    <small class="text-muted fa-pull-right">aaaa-mm-dd</small>
                    <br>
                    <label>{{ __('Supplier') }}</label>
                    <select class="selectpicker form-control" name="supplier">
                        @forelse ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @empty
                        {{ __('no suppliers available!') }}

                        @endforelse
                    </select>
                    <br>
                    <label>{{ __('Work') }}</label>
                    <select class="selectpicker form-control" name="work_id">
                        @forelse ($works as $work)
                        <option value="{{ $work->id }}">{{ $work->name }}</option>
                        @empty
                        {{ __('no work available!') }}
                        @endforelse
                    </select>
                    <br>
                    <br>
                    <a class="btn btn-outline-secondary" href="{!! URL::previous() !!}"><span
                            class="fa fa-arrow-left"></span>&nbsp; {{ __('Back') }}</a>

                    <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-save"></i>&nbsp; {!!
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
