@extends('layouts.backoffice_master')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - Dashboard</title>
@endsection

@section('head-scripts')

@endsection

@section('content')
<div class="row">
    <div class="col">
        @include('flash::message')
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">{{ __('A Sua Lista de Receitas Personalizada!') }}</h5>
				<br>
                <div class="row">
                    @forelse ($user->allowed_recipes() as $recipe)
                    <div class="col-lg-3 pb-2">
                        <div class="card">
                            <div class="card-body text-nowrap">
                                {{$recipe->title}}
                                
                            </div>
                        </div>
                    </div>
                   
                        @empty
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body text-nowrap">
                                    {{__('Não existem receitas para si, consulte o administrador!')}}
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('foot-scripts')

 @endsection
