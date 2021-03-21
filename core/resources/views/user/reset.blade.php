@extends('user.layout')

@section('pagename')
 - {{__('Change Password')}}
@endsection

@section('content')

<!--   hero area start   -->
<div class="breadcrumb-area services service-bg" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
    <div class="container">
        <div class="breadcrumb-txt">
            <div class="row">
                <div class="col-xl-7 col-lg-8 col-sm-10">
                    <h1>{{__('Change Password')}}</h1>
                    <ul class="breadcumb">
                        <li><a href="{{route('user-dashboard')}}">{{__('Dashboard')}}</a></li>
                        <li>{{__('Change Password')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb-area-overlay"></div>
</div>
<!--   hero area end    -->
     <!--====== CHECKOUT PART START ======-->
     <section class="user-dashbord">
        <div class="container">
            <div class="row">
                @include('user.inc.site_bar')
                <div class="col-lg-9">
                    <div class="row mb-5">
                        <div class="col-lg-12">
                            <div class="user-reset">
                                <div class="account-info">
                                    <div class="title">
                                        <h4>{{__('Change Password')}}</h4>
                                    </div>
                                    <div class="edit-info-area">
                                       @if(session()->has('err'))
                                       <p class="text-danger mb-4">{{ session()->get('err') }}</p>
                                       @endif

                                        <form action="{{route('user-reset-submit')}}" method="POST" enctype="multipart/form-data" >
                                            @csrf

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input type="password" class="form_control" placeholder="{{__('Current Password')}}" name="cpass" value="{{Request::old('cpass')}}">
                                                    @error('cpass')
                                                        <p class="text-danger mb-4">{{ convertUtf8($message) }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="password" class="form_control" placeholder="{{__('New Password')}}" name="npass" value="{{Request::old('npass')}}">
                                                    @error('npass')
                                                        <p class="text-danger mb-4">{{ convertUtf8($message) }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input type="password" class="form_control" placeholder="{{__('Confirm Password')}}" name="cfpass" value="{{Request::old('cfpass')}}">
                                                    @error('cfpass')
                                                        <p class="text-danger mb-4">{{ convertUtf8($message) }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-button">
                                                        <button type="submit" class="btn form-btn">{{__('Submit')}}</button>
                                                    </div>
                                                </div>
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
    </section>

@endsection
