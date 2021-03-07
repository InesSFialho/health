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
                <div class="d-flex flex-wrap justify-content-around">
                    <div class="card m-2" style="width: 18rem;">
                        <img class="" style="height: 80%; object-fit: cover;" src="https://smartcharge.com.br/images/paginas/pagina-default.png" alt="Card image cap"
                        >
                        <div class="card-body" style="height: 20%;">
                            <h5 class="card-title">Card title</h5>
                        </div>
                    </div>
                    <div class="card m-2" style="width: 18rem;">
                        <img class="" style="height: 80%; object-fit: cover;" src="https://images.happycow.net/venues/1024/11/12/hcmp111218_399663.jpeg" alt="Card image cap">
                        <div class="card-body" style="height: 20%;">
                            <h5 class="card-title">Card title</h5>
                        </div>
                    </div>
                    <div class="card m-2" style="width: 18rem;">
                        <img class="" style="height: 80%; object-fit: cover;" src="https://www.themediterraneandish.com/wp-content/uploads/2017/09/Egyptian-Vegan-Stew-with-Peas-and-carrots-The-Mediterranean-Dish-5.jpg" alt="Card image cap">
                        <div class="card-body" style="height: 20%;">
                            <h5 class="card-title">Card title</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('foot-scripts')

 @endsection
