@extends("front.$version.layout")

@section('pagename')
 -
 {{__('Forgot Password')}}
@endsection

@section('meta-keywords', "$be->forgot_meta_keywords")
@section('meta-description', "$be->forgot_meta_description")

@section('content')
   <!--   hero area start   -->
   <div class="breadcrumb-area services service-bg" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
    <div class="container">
        <div class="breadcrumb-txt">
            <div class="row">
                <div class="col-xl-7 col-lg-8 col-sm-10">
                    <h1>{{__('Forgot Password')}}</h1>
                    <ul class="breadcumb">
                        <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                        <li>{{__('Forgot Password')}}</li>
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
                        <h3 class="title">{{__('Forgot Password')}}</h3>
                    </div>

                    <form  action="{{route('user-forgot-submit')}}" method="POST">
                        @csrf
                        <div class="input-box">
                            <span>{{__('Email')}} *</span>
                            <input type="email" name="email" value="{{Request::old('email')}}">
                            @error('email')
                            <p class="text-danger mb-2 mt-2">{{ convertUtf8($message) }}</p>
                            @enderror
                            @if(Session::has('err'))
                            <p class="text-danger mb-2 mt-2">{{ Session::get('err') }}</p>
                            @endif
                        </div>

                        <div class="input-btn mt-4">
                            <button type="submit">{{__('Send Mail')}}</button>
                            <p class="d-inline-block float-right"><a href="{{route('user.login')}}">{{__('Login Now')}}</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--   hero area end    -->
@endsection
