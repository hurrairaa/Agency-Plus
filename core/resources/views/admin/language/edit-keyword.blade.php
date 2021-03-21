@extends('admin.layout')

@if (!empty($la) && $la->rtl == 1)
@section('styles')
<style>
    form input {
        direction: rtl;
    }
</style>
@endsection
@endif

@if (empty($la) && $be->default_language_direction == 'rtl')
@section('styles')
<style>
    form input {
        direction: rtl;
    }
</style>
@endsection
@endif

@section('content')
  <div class="page-header">
    <h4 class="page-title">Edit Keyword</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{route('admin.dashboard')}}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Language Management</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Edit Keyword</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Language Keyword</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.language.index')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5" id="app">
          <div class="row">
            <div class="col-lg-12">
              <form method="post" action="{{ !empty($la) ? route('admin.language.updateKeyword', $la->id) : route('admin.language.updateKeyword', 0)}}" id="langForm">
                  {{ csrf_field() }}

                  <div class="row">
                    <div class="col-md-4 mt-2" v-for="(value, key) in datas" :key="key">
                      <div class="form-group">
                        <label class="control-label" style="white-space: normal;">@{{ key }}</label>
                        <div class="input-group">
                            <input type="text" :value="value" :name="'keys[' + key + ']'" class="form-control form-control-lg">
                        </div>
                      </div>
                    </div>
                  </div>

              </form>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="form">
            <div class="form-group from-show-notify row">
              <div class="col-12 text-center">
                <button type="button" class="btn btn-success" onclick="document.getElementById('langForm').submit();">Update</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

@endsection


@section('scripts')
    <script src="{{asset('assets/admin/js/plugin/vue/vue.js')}}"></script>
    <script src="{{asset('assets/admin/js/plugin/vue/axios.js')}}"></script>
    <script>
        window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
    </script>

    <script>
        window.app = new Vue({
            el: '#app',
            data: {
                datas: {!! $json !!},
            }
        })
    </script>

@endsection
