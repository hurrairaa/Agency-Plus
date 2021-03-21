@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.permissions.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-folder fa-fw" aria-hidden="true"></i>
    {{ trans('installer_messages.permissions.title') }}
@endsection

@section('container')

    <ul class="list">
        @foreach($permissions['permissions'] as $permission)
        <li class="list__item list__item--permissions {{ $permission['isSet'] ? 'success' : 'error' }}">
            @if ($permission['folder'] == '../assets/admin/img/')
                assets/admin/img/
            @elseif ($permission['folder'] == '../assets/front/img/')
                assets/front/img/
            @elseif ($permission['folder'] == '../assets/front/invoices/')
                assets/front/invoices/
            @elseif ($permission['folder'] == '../assets/front/ndas/')
                assets/front/ndas/
            @elseif ($permission['folder'] == '../assets/front/temp/')
                assets/front/temp/
            @elseif ($permission['folder'] == '../assets/front/user-suppor-file/')
                assets/front/user-suppor-files/
            @elseif ($permission['folder'] == '../assets/sitemaps/')
                assets/sitemaps/
            @elseif ($permission['folder'] == '../assets/user/img/')
                assets/user/img/
            @else
                core/{{ $permission['folder'] }}
            @endif

            <span>
                <i class="fa fa-fw fa-{{ $permission['isSet'] ? 'check-circle-o' : 'exclamation-circle' }}"></i>
                {{ $permission['permission'] }}
            </span>
        </li>
        @endforeach
    </ul>

    @if ( ! isset($permissions['errors']))
        <div class="buttons">
            <a href="{{ route('LaravelInstaller::license') }}" class="button">
                Verify License
                <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
            </a>
        </div>
    @endif

@endsection
