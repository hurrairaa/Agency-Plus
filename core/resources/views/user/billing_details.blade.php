@extends('user.layout')

@section('pagename')
 - {{__('Billing Details')}}
@endsection

@section('content')

<!--   hero area start   -->
<div class="breadcrumb-area services service-bg" style="background-image: url('{{asset  ('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
    <div class="container">
        <div class="breadcrumb-txt">
            <div class="row">
                <div class="col-xl-7 col-lg-8 col-sm-10">
                    <h1>{{__('Billing Details')}}</h1>
                    <ul class="breadcumb">
                        <li><a href="{{route('user-dashboard')}}">{{__('Dashboard')}}</a></li>
                        <li>{{__('Billing Details')}}</li>
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
                            <div class="user-profile-details">
                                <div class="account-info">
                                    <div class="title">
                                        <h4>{{__('Billing Details')}}</h4>
                                    </div>
                                    <div class="edit-info-area">
                                        <form action="{{route('billing-update')}}" method="POST" enctype="multipart/form-data" >
                                            @csrf

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control" placeholder="{{__('First Name')}}" name="billing_fname" value="{{convertUtf8($user->billing_fname)}}">
                                                    @error('billing_fname')
                                                        <p class="text-danger mb-2">{{ convertUtf8($message) }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control" placeholder="{{__('Last Name')}}" name="billing_lname" value="{{convertUtf8($user->billing_lname)}}">
                                                    @error('billing_lname')
                                                        <p class="text-danger mb-2">{{ convertUtf8($message) }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="email" class="form_control" placeholder="{{__('Email')}}" name="billing_email"  value="{{convertUtf8($user->billing_email)}}">
                                                    @error('billing_email')
                                                    <p class="text-danger mb-2">{{ convertUtf8($message) }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control" placeholder="{{__('Phone')}}" name="billing_number" value="{{convertUtf8($user->billing_number)}}">
                                                    @error('billing_number')
                                                    <p class="text-danger mb-2">{{ convertUtf8($message) }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control" placeholder="{{__('City')}}" name="billing_city" value="{{convertUtf8($user->billing_city)}}">
                                                    @error('billing_city')
                                                    <p class="text-danger mb-2">{{ convertUtf8($message) }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control" placeholder="{{__('State')}}" name="billing_state" value="{{convertUtf8($user->billing_state)}}">
                                                    @error('billing_state')
                                                    <p class="text-danger mb-2">{{ convertUtf8($message) }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control" placeholder="{{__('Country')}}" name="billing_country" value="{{convertUtf8($user->billing_country)}}">
                                                    @error('billing_country')
                                                    <p class="text-danger mb-2">{{ convertUtf8($message) }}</p>
                                                    @enderror
                                                </div>


                                                <div class="col-lg-12">
                                                    <textarea name="billing_address" class="form_control" placeholder="{{__('Address')}}">{{convertUtf8($user->billing_address)}}</textarea>
                                                    @error('billing_address')
                                                    <p class="text-danger">{{ convertUtf8($message) }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-button">
                                                        <button type="submit" class="btn form-btn">{{__('Submit')}}</button>
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

