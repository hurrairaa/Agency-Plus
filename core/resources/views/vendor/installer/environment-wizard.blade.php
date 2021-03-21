@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.environment.wizard.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-database fa-fw" aria-hidden="true"></i>
    {!! trans('installer_messages.environment.wizard.title') !!}
@endsection

@section('container')
    <div class="tabs tabs-full">
        @if(session()->has('license_success'))
            <div class="alert alert-success" style="background-color: #d4edda;" id="license_alert">
                <p style="margin-bottom: 0px;color: #155724;">{{session()->get('license_success')}}</p>
            </div>
        @endif

        <form method="post" action="{{ route('LaravelInstaller::environmentSaveWizard') }}" class="tabs-wrap">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div>
                <div class="form-group {{ $errors->has('app_name') ? ' has-error ' : '' }}">
                    <label for="app_name">
                        {{ trans('installer_messages.environment.wizard.form.app_name_label') }}
                    </label>
                    <input type="text" name="app_name" id="app_name" value="" placeholder="{{ trans('installer_messages.environment.wizard.form.app_name_placeholder') }}" />
                    @if ($errors->has('app_name'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_name') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('app_debug') ? ' has-error ' : '' }}" style="margin-bottom: 5px;">
                    <label for="app_debug">
                        {{ trans('installer_messages.environment.wizard.form.app_debug_label') }}
                    </label>
                    <label for="app_debug_true">
                        <input type="radio" name="app_debug" id="app_debug_true" value=true />
                        {{ trans('installer_messages.environment.wizard.form.app_debug_label_true') }}
                    </label>
                    <label for="app_debug_false">
                        <input type="radio" name="app_debug" id="app_debug_false" value=false checked />
                        {{ trans('installer_messages.environment.wizard.form.app_debug_label_false') }}
                    </label>
                    @if ($errors->has('app_debug'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_debug') }}
                        </span>
                    @endif
                </div>


                <div class="form-group {{ $errors->has('app_url') ? ' has-error ' : '' }}">
                    <label for="app_url">
                        {{ trans('installer_messages.environment.wizard.form.app_url_label') }}
                    </label>
                    <input type="url" name="app_url" id="app_url" value="http://localhost" placeholder="{{ trans('installer_messages.environment.wizard.form.app_url_placeholder') }}" />
                    @if ($errors->has('app_url'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_url') }}
                        </span>
                    @endif
                </div>


                <div class="form-group {{ $errors->has('database_hostname') ? ' has-error ' : '' }}">
                    <label for="database_hostname">
                        {{ trans('installer_messages.environment.wizard.form.db_host_label') }}
                    </label>
                    <input type="text" name="database_hostname" id="database_hostname" value="127.0.0.1" placeholder="{{ trans('installer_messages.environment.wizard.form.db_host_placeholder') }}" />
                    @if ($errors->has('database_hostname'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_hostname') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_name') ? ' has-error ' : '' }}">
                    <label for="database_name">
                        {{ trans('installer_messages.environment.wizard.form.db_name_label') }}
                    </label>
                    <input type="text" name="database_name" id="database_name" value="" placeholder="{{ trans('installer_messages.environment.wizard.form.db_name_placeholder') }}" />
                    @if ($errors->has('database_name'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_name') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_username') ? ' has-error ' : '' }}">
                    <label for="database_username">
                        {{ trans('installer_messages.environment.wizard.form.db_username_label') }}
                    </label>
                    <input type="text" name="database_username" id="database_username" value="" placeholder="{{ trans('installer_messages.environment.wizard.form.db_username_placeholder') }}" />
                    @if ($errors->has('database_username'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_username') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('database_password') ? ' has-error ' : '' }}">
                    <label for="database_password">
                        {{ trans('installer_messages.environment.wizard.form.db_password_label') }}
                    </label>
                    <input type="password" name="database_password" id="database_password" value="" placeholder="{{ trans('installer_messages.environment.wizard.form.db_password_placeholder') }}" />
                    @if ($errors->has('database_password'))
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_password') }}
                        </span>
                    @endif
                </div>

                <div class="buttons">
                    <button class="button" type="submit">
                        {{ trans('installer_messages.environment.wizard.form.buttons.install') }}
                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

        </form>

    </div>
@endsection

