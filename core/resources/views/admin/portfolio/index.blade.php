@extends('admin.layout')

@php
$selLang = \App\Language::where('code', request()->input('language'))->first();
@endphp
@if(!empty($selLang) && $selLang->rtl == 1)
@section('styles')
<style>
    form:not(.modal-form) input,
    form:not(.modal-form) textarea,
    form:not(.modal-form) select,
    select[name='language'] {
        direction: rtl;
    }
    form:not(.modal-form) .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection
@endif

@section('content')
  <div class="page-header">
    <h4 class="page-title">Portfolios</h4>
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
        <a href="#">Portfolio Page</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Portfolios</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-title d-inline-block">Portfolios</div>
                </div>
                <div class="col-lg-3">
                    @if (!empty($langs))
                        <select name="language" class="form-control" onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                            <option value="" selected disabled>Select a Language</option>
                            @foreach ($langs as $lang)
                                <option value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
                <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                    <a href="{{route('admin.portfolio.create') . '?language=' . request()->input('language')}}" class="btn btn-primary float-right btn-sm"><i class="fas fa-plus"></i> Add Portfolio</a>
                    <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.portfolio.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($portfolios) == 0)
                <h3 class="text-center">NO PORTFOLIO FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">
                            <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">Featured Image</th>
                        <th scope="col">Title</th>
                        <th scope="col">Service</th>
                        <th scope="col">Featured</th>
                        <th scope="col">Serial Number</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($portfolios as $key => $portfolio)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{$portfolio->id}}">
                          </td>
                          <td><img src="{{asset('assets/front/img/portfolios/featured/'.$portfolio->featured_image)}}" width="80"></td>
                          <td>{{strlen(convertUtf8($portfolio->title)) > 200 ? convertUtf8(substr($portfolio->title, 0, 200)) . '...' : convertUtf8($portfolio->title)}}</td>
                          <td>
                            @if (!empty($portfolio->service))
                            {{convertUtf8($portfolio->service->title)}}
                            @endif
                          </td>
                          <td>
                            <form id="featureForm{{$portfolio->id}}" class="d-inline-block" action="{{route('admin.portfolio.feature')}}" method="post">
                            @csrf
                            <input type="hidden" name="portfolio_id" value="{{$portfolio->id}}">
                            <select class="form-control {{$portfolio->feature == 1 ? 'bg-success' : 'bg-danger'}}" name="feature" onchange="document.getElementById('featureForm{{$portfolio->id}}').submit();">
                                <option value="1" {{$portfolio->feature == 1 ? 'selected' : ''}}>Yes</option>
                                <option value="0" {{$portfolio->feature == 0 ? 'selected' : ''}}>No</option>
                            </select>
                            </form>
                          </td>
                          <td>{{$portfolio->serial_number}}</td>
                          <td>
                            <a class="btn btn-secondary btn-sm" href="{{route('admin.portfolio.edit', $portfolio->id) . '?language=' . request()->input('language')}}">
                            <span class="btn-label">
                              <i class="fas fa-edit"></i>
                            </span>
                            Edit
                            </a>
                            <form class="deleteform d-inline-block" action="{{route('admin.portfolio.delete')}}" method="post">
                              @csrf
                              <input type="hidden" name="portfolio_id" value="{{$portfolio->id}}">
                              <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                <span class="btn-label">
                                  <i class="fas fa-trash"></i>
                                </span>
                                Delete
                              </button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endif
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="d-inline-block mx-auto">
              {{$portfolios->appends(['language' => request()->input('language')])->links()}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
