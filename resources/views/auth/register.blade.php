@extends('layouts.backoffice_master_nm')
<style>
.inner-addon { 
    position: relative; 
}

/* style icon */
.inner-addon .fas {
  position: absolute;
  padding: 15px;
  pointer-events: none;
}

/* align icon */
.left-addon .fas  { left:  0px;}
.right-addon .fas { right: 0px;}

/* add padding  */
.left-addon input  { padding-left:  40px; }
.right-addon input { padding-right: 30px; }

#login .fa-at, #login .fa-mobile-alt {
color: gray;
margin: 5px;
display: inline-block;
border-radius: 60px;
box-shadow: 0px 0px 2px #888;
padding: 0.5em 0.6em;
}

#login {
  background-image: url({{ url( Base::bg1()->url  . Base::bg1()->file) }});
  background-repeat: no-repeat;
  background-size: cover;
}
</style>

@section('content')
<section id="login">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="wrapper fadeInDown ">
                <div id="formContent">
                    <div class="fadeIn first">
                        <h3 class="py-4">{{ __('Register') }}</h3>
                        <!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registo') }}</div> -->
                        <div class="card">
                            <div class="card-body" style="color: #808080;">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf


                                    <div class="form-group row">
                                        <label for="name" class="col-12 col-form-label">{{ __('Name') }}</label>

                                        <div class="col-12">
                                        <div class="inner-addon left-addon">
                                        <i class="fas fa-user"></i>
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                       
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-12 col-form-label">{{ __('Endereço de Email') }}</label>
                                        <div class="col-12">
                                        <div class="inner-addon left-addon">
                                        <i class="fas fa-at"></i>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="phone" class="col-12 col-form-label">{{ __('Telefone') }}</label>
                                        <div class="col-12">
                                        <div class="inner-addon left-addon">
                                        <i class="fas fa-mobile-alt"></i>
                                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                            @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-12 col-form-label">{{ __('Password') }}</label>

                                        <div class="col-12">
                                        <div class="inner-addon left-addon">
                                        <i class="fas fa-lock"></i>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-12 col-form-label">{{ __('Confirmar Password') }}</label>

                                        <div class="col-12">
                                        <div class="inner-addon left-addon">
                                        <i class="fas fa-lock"></i>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-secondary">
                                                {{ __('Registar') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @endsection