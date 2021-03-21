@extends("front.$version.layout")

@section('pagename')
 -
 {{__('Login')}}
@endsection


@section('meta-keywords', "$be->login_meta_keywords")
@section('meta-description', "$be->login_meta_description")


@section('content')
   <!--   hero area start   -->
   <div class="breadcrumb-area services service-bg" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
    <div class="container">
        <div class="breadcrumb-txt">
            <div class="row">
                <div class="col-xl-7 col-lg-8 col-sm-10">
                    <h1>{{__('Sign In')}}</h1>
                    <ul class="breadcumb">
                        <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                        <li>{{__('Sign In')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb-area-overlay"></div>
</div>
<!--   hero area end    -->


<!--   hero area start    -->
<div class="login-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="login-content">
                    <div class="login-title">
                        <h3 class="title">{{__('Login')}}</h3>
                    </div>
                    <form id="loginForm" action="{{route('user.login')}}" method="POST">
                        @csrf
                        <div class="input-box">
                            <span>{{__('Email')}} *</span>
                            <input type="email" name="email" value="{{Request::old('email')}}">
                            @if(Session::has('err'))
                                <p class="text-danger mb-2 mt-2">{{Session::get('err')}}</p>
                            @endif
                            @error('email')
                            <p class="text-danger mb-2 mt-2">{{ convertUtf8($message) }}</p>
                            @enderror
                        </div>
                        <div class="input-box mb-4">
                            <span>{{__('Password')}} *</span>
                            <input type="password" name="password" value="{{Request::old('password')}}">
                            @error('password')
                            <p class="text-danger mb-2 mt-2">{{ convertUtf8($message) }}</p>
                            @enderror
                        </div>

                        @if ($bs->is_recaptcha == 1)
                        <div class="d-block mb-4">
                            {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display() !!}
                            @if ($errors->has('g-recaptcha-response'))
                            @php
                                $errmsg = $errors->first('g-recaptcha-response');
                            @endphp
                            <p class="text-danger mb-0 mt-2">{{__("$errmsg")}}</p>
                            @endif
                        </div>
                    @endif

                        <div class="input-btn">
                            <button type="submit">{{__('LOG IN')}}</button><br>
                            <p class="float-lg-right float-left">{{__("Don't have an account ?")}} <a href="{{route('user-register')}}">{{__('Click Here')}}</a> {{__('to create one.')}}</p>
                            <a class="mr-3" href="{{route('user-forgot')}}">{{__('Lost your password?')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--   hero area end    -->
@endsection
