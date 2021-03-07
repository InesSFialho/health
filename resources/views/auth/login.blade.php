@extends('layouts.backoffice_master_nm')

@section('head-meta')
	<title>{{ str_replace('.', ' ', config('app.name')) }} - Login</title>
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
@if(!empty(Base::bg1()->url))
#login {
  background-image: url({{ url( Base::bg1()->url  . Base::bg1()->file) }});
  background-repeat: no-repeat;
  background-size: cover;
}
@endif

#login a {
color: #666 !important;
display: inline-block;
text-decoration: none;
font-weight: 400;
}

#content {
	padding: 0px !important;
}

	</style>
@endsection



@section('content')
<section id="login">
	<div class="wrapper fadeInDown" style="height: 100vh">
		<div class="my-3">
			@include('flash::message')
		</div>
		<div id="formContent">
			<div class="fadeIn first">
                <div style="margin: 20px;">
				@if(!empty(Base::logo_backoffice()->url))
                	<img id="img_logo" src="{{ url( Base::logo_backoffice()->url  . Base::logo_backoffice()->file) }}" style="max-height: 15vh;" />
                @endif
				</div>
                <div>
                    <!--<h3 style=" color: rgba(255, 255, 255, 0.7);text-shadow: 1px 1px 3px #000000; letter-spacing: 3px; "> {{ str_replace('.', ' ', config('app.name')) }}</h3> -->
                </div>
            </div>
			<form method="POST" action="{{ route('login') }}" id="loginform" name="loginform">
				@csrf
				<div class="input-group">
				<div class="inner-addon left-addon">
				<i class="fas fa-user" aria-hidden="true"></i>
					<input id="email" style="background: transparent; border: none;" type="email" style="background-color: none;" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
					@error('email')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</div>
				</div>

				<div class="input-group">
				<div class="inner-addon left-addon">
				<i class="fas fa-lock" aria-hidden="true"></i>
					<input id="password"   type="password" style="background: transparent; border: none;"  class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
					@error('password')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
					</div>
				</div>
				<button type="submit" class="fadeIn fourth" id="login1">
				{{ __('Login') }}
				</button>
			</form>
			<div id="formFooter">
				@if (Route::has('password.request'))
					<a class="btn btn-link" id="passwordReset" href="{{ route('password.request') }}">
					{{ __('Forgot password?') }}
					</a>
				@endif
				
			</div>
		</div>
	</div>
</section>
@endsection

@section('foot-scripts')
	
@endsection
