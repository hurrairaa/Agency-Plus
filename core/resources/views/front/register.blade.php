@extends("front.$version.layout")

@section('pagename')
 -
 {{__('Register')}}
@endsection

@section('meta-keywords', "$be->register_meta_keywords")
@section('meta-description', "$be->register_meta_description")

@section('content')
    <!--   hero area start   -->
    <div class="breadcrumb-area services service-bg" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
        <div class="container">
            <div class="breadcrumb-txt">
                <div class="row">
                    <div class="col-xl-7 col-lg-8 col-sm-10">
                        <h1>{{__('Sign Up')}}</h1>
                        <ul class="breadcumb">
                            <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                            <li>{{__('Sign Up')}}</li>
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
                        @if(Session::has('sendmail'))
                        <div class="alert alert-success mb-4">
                            <p style="line-height: 24px;">{{Session::get('sendmail')}}</p>
                        </div>
                        @endif
                        <div class="login-title">
                            <h3 class="title">{{__('Register')}}</h3>
                        </div>

                        <form action="{{route('user-register-submit')}}" method="POST">@csrf
                            <div class="input-box">
                                <span>{{__('Username')}} *</span>
                                <input type="text" name="username" value="{{Request::old('username')}}">
                                @if ($errors->has('username'))
                                <p class="text-danger mb-0 mt-2">{{$errors->first('username')}}</p>
                                @endif
                            </div>
                            <div class="input-box">
                                <span>{{__('Email')}} *</span>
                                <input type="email" name="email" value="{{Request::old('email')}}">
                                @if ($errors->has('email'))
                                <p class="text-danger mb-0 mt-2">{{$errors->first('email')}}</p>
                                @endif
                            </div>
                            <div class="input-box">
                                <span>{{__('Password')}} *</span>
                                <input type="password" name="password" value="{{Request::old('password')}}">
                                @if ($errors->has('password'))
                                <p class="text-danger mb-0 mt-2">{{$errors->first('password')}}</p>
                                @endif
                            </div>
                            <div class="input-box mb-4">
                                <span>{{__('Confirmation Password')}} *</span>
                                <input type="password" name="password_confirmation" value="{{Request::old('password_confirmation')}}">
                                @if ($errors->has('password_confirmation'))
                                <p class="text-danger mb-0 mt-2">{{$errors->first('password_confirmation')}}</p>
                                @endif
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
                                <button type="submit">{{__('Register')}}</button>
                                <p>{{__('Already have an account ?')}} <a class="mr-3" href="{{route('user.login')}}">{{__('Click Here')}}</a> {{__('to login')}}.</p>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--   hero area end    -->
@endsection
