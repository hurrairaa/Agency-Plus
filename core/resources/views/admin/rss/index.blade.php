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
   <h4 class="page-title">RSS Feed Posts</h4>
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
         <a href="#">RSS Feeds</a>
      </li>
      <li class="separator">
         <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
         <a href="#">RSS Posts</a>
      </li>
   </ul>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <div class="row">
               <div class="col-lg-4">
                  <div class="card-title d-inline-block">RSS Feed Posts</div>
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
               <div class="col-lg-5">
                  <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.rss.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
               </div>
            </div>
         </div>

         @if (count($rsss) == 0)
         <div class="card-body">
            <h3 class="text-center">NO RSS POST FOUND</h3>
         </div>
         @else
         <div class="card-body">
            <div class="row">
               <div class="col-lg-12">

                  <div class="table-responsive">
                     <table class="table table-striped mt-3">
                        <thead>
                           <tr>
                              <th scope="col">
                                <input type="checkbox" class="bulk-check" data-val="all">
                              </th>
                              <th scope="col">Image</th>
                              <th scope="col">Category</th>
                              <th scope="col">Title</th>
                              <th scope="col">Created at</th>
                              <th scope="col">Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($rsss as $key => $rss)
                           <tr>
                              <td>
                                <input type="checkbox" class="bulk-check" data-val="{{$rss->id}}">
                              </td>
                              <td><img src="{{ $rss->photo}}" alt="" width="80"></td>
                              <td>{{convertUtf8($rss->category->feed_name)}}</td>
                              <td>{{convertUtf8(strlen($rss->title)) > 30 ? convertUtf8(substr($rss->title, 0, 30)) . '...' : convertUtf8($rss->title)}}</td>
                              <td>
                                 @php
                                 $date = \Carbon\Carbon::parse($rss->created_at);
                                 @endphp
                                 {{$date->translatedFormat('jS F, Y')}}
                              </td>
                              <td>
                                <form class="deleteform d-inline-block" action="{{ route('admin.rss.delete')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$rss->id}}">
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
               </div>
            </div>
         </div>
         <div class="card-footer">
            <div class="row">
               <div class="d-inline-block mx-auto">
                  {{$rsss->appends(['language' => request()->input('language')])->links()}}
               </div>
            </div>
         </div>
         @endif
      </div>
   </div>
</div>

@endsection

@section('scripts')

@endsection
