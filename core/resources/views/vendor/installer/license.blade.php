@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.license.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-key fa-fw" aria-hidden="true"></i>
    {!! trans('installer_messages.license.title') !!}
@endsection

@section('container')
    <div class="tabs tabs-full">



        <form method="post" action="{{ route('LaravelInstaller::licenseCheck') }}" class="tabs-wrap">
            @if(session()->has('license_error'))
                <div class="alert alert-danger" id="error_alert">
                    <button type="button" class="close" id="close_alert" data-dismiss="alert" aria-hidden="true">
                        <i class="fa fa-close" aria-hidden="true"></i>
                    </button>
                    <p style="margin-bottom: 0px;">{{session()->get('license_error')}}</p>
                </div>
            @endif

            <div class="alert alert-warning" style="background-color: #fff3cd; color: #856404;">
                <p style="margin-bottom: 0px;">If your internet connection is off, then please turn it on first</p>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div>
                <div class="form-group {{ $errors->has('email') ? ' has-error ' : '' }}">
                    <label for="email">
                        Email Address
                    </label>
                    <input type="text" name="email" id="email" value="" placeholder="Your Mail Address" />
                    <p>This Mail Address will be used to inform you about Urgent Notices, Announcements, Offers / Sales etc...</p>
                    @if ($errors->has('email'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('username') ? ' has-error ' : '' }}">
                    <label for="username">
                        Envato Username
                    </label>
                    <input type="text" name="username" id="username" value="" placeholder="Username of Your Envato Account" />
                    @if ($errors->has('username'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('username') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('purchase_code') ? ' has-error ' : '' }}">
                    <label for="purchase_code">
                        Purchase Code
                    </label>
                    <input type="text" name="purchase_code" id="purchase_code" value="" placeholder="Your Item Purchase Code" />
                    @if ($errors->has('purchase_code'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('purchase_code') }}
                        </span>
                    @endif
                </div>

                <div class="buttons">
                    <button class="button" type="submit" style="font-size: 14px;">
                        Verify
                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

        </form>

    </div>
@endsection

