@extends('admin.layout')

@section('styles')
<link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap-iconpicker.min.css')}}">
@endsection

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
    <h4 class="page-title">Drag & Drop Menu Builder</h4>
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
        <a href="#">Menu Builder</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card-title">Menu Builder</div>
                </div>
                <div class="col-lg-2">
                    @if (!empty($langs))
                        <select name="language" class="form-control" onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                            <option value="" selected disabled>Select a Language</option>
                            @foreach ($langs as $lang)
                                <option value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body pt-5 pb-5">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card border-primary mb-3">
                        <div class="card-header bg-primary text-white">Choose from Redymade Menus</div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item">{{__('Home')}} <a data-text="{{__('Home')}}" data-type="home" class="addToMenus btn btn-primary btn-sm float-right" href="">Add to Menus</a></li>
                                <li class="list-group-item">{{__('Services')}} <a data-text="{{__('Services')}}" data-type="services" class="addToMenus btn btn-primary btn-sm float-right" href="">Add to Menus</a></li>
                                <li class="list-group-item">{{__('Packages')}} <a data-text="{{__('Packages')}}" data-type="packages" class="addToMenus btn btn-primary btn-sm float-right" href="">Add to Menus</a></li>
                                <li class="list-group-item">{{__('Portfolios')}} <a data-text="{{__('Portfolios')}}" data-type="portfolios" class="addToMenus btn btn-primary btn-sm float-right" href="">Add to Menus</a></li>

                                @foreach ($pages as $page)
                                    <li class="list-group-item">{{$page->name}} <a data-text="{{$page->name}}" data-type="{{$page->id}}" class="addToMenus btn btn-primary btn-sm float-right" href="">Add to Menus</a></li>
                                @endforeach

                                <li class="list-group-item">{{__('Team Members')}} <a data-text="{{__('Team Members')}}" data-type="team" class="addToMenus btn btn-primary btn-sm float-right" href="">Add to Menus</a></li>
                                <li class="list-group-item">{{__('Career')}} <a data-text="{{__('Career')}}" data-type="career" class="addToMenus btn btn-primary btn-sm float-right" href="">Add to Menus</a></li>
                                <li class="list-group-item">{{__('Event Calendar')}} <a data-text="{{__('Event Calendar')}}" data-type="calendar" class="addToMenus btn btn-primary btn-sm float-right" href="">Add to Menus</a></li>
                                <li class="list-group-item">{{__('Gallery')}} <a data-text="{{__('Gallery')}}" data-type="gallery" class="addToMenus btn btn-primary btn-sm float-right" href="">Add to Menus</a></li>
                                <li class="list-group-item">{{__('FAQ')}} <a data-text="{{__('FAQ')}}" data-type="faq" class="addToMenus btn btn-primary btn-sm float-right" href="">Add to Menus</a></li>


                                <li class="list-group-item">{{__('Products')}} <a data-text="{{__('Products')}}" data-type="products" class="addToMenus btn btn-primary btn-sm float-right" href="">Add to Menus</a></li>
                                <li class="list-group-item">{{__('Cart')}} <a data-text="{{__('Cart')}}" data-type="cart" class="addToMenus btn btn-primary btn-sm float-right" href="">Add to Menus</a></li>
                                <li class="list-group-item">{{__('Checkout')}} <a data-text="{{__('Checkout')}}" data-type="checkout" class="addToMenus btn btn-primary btn-sm float-right" href="">Add to Menus</a></li>


                                <li class="list-group-item">{{__('Our Blogs')}} <a data-text="{{__('Our Blogs')}}" data-type="blogs" class="addToMenus btn btn-primary btn-sm float-right" href="">Add to Menus</a></li>
                                <li class="list-group-item">{{__('RSS News')}} <a data-text="{{__('RSS News')}}" data-type="rss" class="addToMenus btn btn-primary btn-sm float-right" href="">Add to Menus</a></li>
                                <li class="list-group-item">{{__('Contact')}} <a data-text="{{__('Contact')}}" data-type="contact" class="addToMenus btn btn-primary btn-sm float-right" href="">Add to Menus</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-primary mb-3">
                        <div class="card-header bg-primary text-white">Add / Edit Menu</div>
                        <div class="card-body">
                            <form id="frmEdit" class="form-horizontal">
                                <input class="item-menu" type="hidden" name="type" value="">

                                <div id="withUrl">
                                    <div class="form-group">
                                        <label for="text">Text</label>
                                        <input type="text" class="form-control item-menu" name="text" placeholder="Text">
                                    </div>
                                    <div class="form-group">
                                        <label for="href">URL</label>
                                        <input type="text" class="form-control item-menu" name="href" placeholder="URL">
                                    </div>
                                    <div class="form-group">
                                        <label for="target">Target</label>
                                        <select name="target" id="target" class="form-control item-menu">
                                            <option value="_self">Self</option>
                                            <option value="_blank">Blank</option>
                                            <option value="_top">Top</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="withoutUrl" style="display: none;">
                                    <div class="form-group">
                                        <label for="text">Text</label>
                                        <input type="text" class="form-control item-menu" name="text" placeholder="Text">
                                    </div>
                                    <div class="form-group">
                                        <label for="href">URL</label>
                                        <input type="text" class="form-control item-menu" name="href" placeholder="URL">
                                    </div>
                                    <div class="form-group">
                                        <label for="target">Target</label>
                                        <select name="target" class="form-control item-menu">
                                            <option value="_self">Self</option>
                                            <option value="_blank">Blank</option>
                                            <option value="_top">Top</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i class="fas fa-sync-alt"></i> Update</button>
                            <button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">Website Menus</div>
                        <div class="card-body">
                            <ul id="myEditor" class="sortableLists list-group">
                            </ul>
                        </div>
                    </div>
                    {{-- <div class="card">
                        <div class="card-body">
                            <div class="form-group"><textarea id="out" class="form-control" cols="50" rows="10"></textarea>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="card-footer pt-3">
            <div class="form">
                <div class="form-group from-show-notify row">
                    <div class="col-12 text-center">
                        <button id="btnOutput" class="btn btn-success">Update Menu</button>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>

@endsection



@section('scripts')
<script type="text/javascript" src="{{asset('assets/admin/js/plugin/jquery-menu-editor/jquery-menu-editor.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/plugin/bootstrap-iconpicker/iconset/fontawesome5-3-1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/plugin/bootstrap-iconpicker/bootstrap-iconpicker.min.js')}}"></script>
<script>
    function disableWithUrl() {
        $("#withUrl input").removeClass('item-menu');
        $("#withUrl select").removeClass('item-menu');
    }

    function enableWithUrl() {
        $("#withUrl input").addClass('item-menu');
        $("#withUrl select").addClass('item-menu');
    }

    function disableWithoutUrl() {
        $("#withoutUrl input").removeClass('item-menu');
        $("#withoutUrl select").removeClass('item-menu');
    }

    function enableWithoutUrl() {
        $("#withoutUrl input").addClass('item-menu');
        $("#withoutUrl select").addClass('item-menu');
    }

    jQuery(document).ready(function () {
        /* =============== DEMO =============== */
        // menu items
        var arrayjson = {!! json_encode($prevMenu) !!};

        // icon picker options
        var iconPickerOptions = {searchText: "Buscar...", labelHeader: "{0}/{1}"};
        // sortable list options
        var sortableListOptions = {
            placeholderCss: {'background-color': "#cccccc"}
        };

        var editor = new MenuEditor('myEditor', {listOptions: sortableListOptions, iconPicker: iconPickerOptions});
        editor.setForm($('#frmEdit'));
        editor.setUpdateButton($('#btnUpdate'));
        // $('#btnReload').on('click', function () {

            editor.setData({!! $prevMenu !!});
        // });

        $('#btnOutput').on('click', function () {
            var str = editor.getString();
            let fd = new FormData();
            // fd.append('language_id', );
            fd.append('str', str);
            fd.append('language_id', {{$lang_id}});

            $.ajax({
                url: "{{route('admin.menu_builder.update')}}",
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data == "success") {
                        location.reload();
                    }
                }
            });
        });

        $("#btnUpdate").click(function(){
            disableWithoutUrl();
            editor.update();
            enableWithoutUrl();
        });

        $('#btnAdd').click(function(){
            disableWithoutUrl();
            $("input[name='type']").val('custom');
            editor.add();
            enableWithoutUrl();
        });
        /* ====================================== */



        // when menu is chosen from readymade menus list
        $(".addToMenus").on('click', function(e) {
            e.preventDefault();
            disableWithUrl();
            $("input[name='type']").val($(this).data('type'));
            $("#withoutUrl input[name='text']").val($(this).data('text'));
            $("#withoutUrl input[name='target']").val('_self');
            editor.add();
            enableWithUrl();

        });
    });
</script>
@endsection
