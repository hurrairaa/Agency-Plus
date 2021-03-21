@extends('user.layout')

@section('content')

<!--   hero area start   -->
<div class="breadcrumb-area services service-bg" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
    <div class="container">
        <div class="breadcrumb-txt">
            <div class="row">
                <div class="col-xl-7 col-lg-8 col-sm-10">
                    <h1>{{__('Edit Profile')}}</h1>
                    <ul class="breadcumb">
                        <li><a href="{{route('user-dashboard')}}">{{__('Dashboard')}}</a></li>
                        <li>{{__('Edit Profile')}}</li>
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
                                        <h4>{{__('Edit Profile')}}</h4>
                                    </div>
                                    <div class="edit-info-area">
                                        <form action="{{route('user-profile-update')}}" method="POST" enctype="multipart/form-data" >
                                            @csrf
                                            <div class="upload-img">
                                                <div class="img-box">
                                                <img class="showimage" src="{{$user->photo ? asset('assets/front/img/user/'.$user->photo) : asset('assets/user/img/profile.jpg')}}" alt="user-image">
                                                </div>
                                                <div class="file-upload-area">
                                                    <div class="upload-file">
                                                        <input type="file" name="photo" class="upload image">
                                                        <span>{{__('Upload')}}</span>
                                                    </div>
                                                    @error('photo')
                                                        <p class="text-danger" >{{ convertUtf8($message) }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control" placeholder="{{__('First Name')}}" name="fname" value="{{convertUtf8($user->fname)}}" value="{{Request::old('fname')}}">
                                                    @error('fname')
                                                        <p class="text-danger mb-4">{{ convertUtf8($message) }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control" placeholder="{{__('Last Name')}}" name="lname" value="{{convertUtf8($user->lname)}}" value="{{Request::old('lname')}}">
                                                    @error('lname')
                                                        <p class="text-danger mb-4">{{ convertUtf8($message) }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <input type="email" class="form_control" placeholder="{{__('Email')}}" name="email" disabled value="{{convertUtf8($user->email)}}" value="{{Request::old('email')}}">
                                                </div>

                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control" placeholder="{{__('Phone')}}" name="number" value="{{$user->number}}" value="{{Request::old('number')}}">
                                                    @error('number')
                                                    <p class="text-danger mb-4">{{ convertUtf8($message) }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control" placeholder="{{__('City')}}" name="city" value="{{convertUtf8($user->city)}}" value="{{Request::old('city')}}">
                                                    @error('city')
                                                    <p class="text-danger mb-4">{{ convertUtf8($message) }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control" placeholder="{{__('State')}}" name="state" value="{{convertUtf8($user->state)}}" value="{{Request::old('state')}}">
                                                    @error('state')
                                                    <p class="text-danger mb-4">{{ convertUtf8($message) }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form_control" placeholder="{{__('Country')}}" name="country" value="{{convertUtf8($user->country)}}" value="{{Request::old('country')}}">
                                                    @error('country')
                                                    <p class="text-danger mb-4">{{ convertUtf8($message) }}</p>
                                                    @enderror
                                                </div>


                                                <div class="col-lg-12">
                                                    <textarea name="address" class="form_control" placeholder="{{__('Address')}}">{{convertUtf8($user->address)}}</textarea>
                                                    @error('address')
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

@section('scripts')

    <script>

        $(document).on('change','.image',function(){
            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.showimage').attr('src',e.target.result)
            };

        reader.readAsDataURL(file);
        })
    </script>
@endsection
