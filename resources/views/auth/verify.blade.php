@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Veryfing you email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('We send a new link to you email.') }}
                        </div>
                    @endif
                    
                    {{ __('Before continue verify your email.') }}
                    {{ __('If you not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('clique aqui para enviar-mos outro') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
