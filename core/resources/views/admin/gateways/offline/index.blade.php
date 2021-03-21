@extends('admin.layout')

@section('content')
<div class="page-header">
   <h4 class="page-title">Offline Gateways</h4>
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
         <a href="#">Payment Gateways</a>
      </li>
      <li class="separator">
         <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
         <a href="#">Offline Gateways</a>
      </li>
   </ul>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <div class="row">
               <div class="col-lg-4">
                  <div class="card-title d-inline-block">Offline Gateways</div>
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
                  <a href="#" class="btn btn-primary float-lg-right float-left btn-sm" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Add Gateway</a>
                  <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.package.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
               </div>
            </div>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-lg-12">
                  @if (count($ogateways) == 0)
                  <h3 class="text-center">NO OFFLINE PAYMENT GATEWAY FOUND</h3>
                  @else
                  <div class="table-responsive">
                     <table class="table table-striped mt-3">
                        <thead>
                           <tr>
                              <th scope="col">Name</th>
                              <th scope="col">Product Checkout</th>
                              <th scope="col">Package Order</th>
                              <th scope="col">Serial Number</th>
                              <th scope="col">Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($ogateways as $key => $ogateway)
                           <tr>
                              <td>
                                {{convertUtf8($ogateway->name)}}
                              </td>
                              <td>
                                <form id="productForm{{$ogateway->id}}" class="d-inline-block" action="{{route('admin.offline.status')}}" method="post">
                                @csrf
                                <input type="hidden" name="ogateway_id" value="{{$ogateway->id}}">
                                <input type="hidden" name="type" value="product">
                                <select class="form-control {{$ogateway->product_checkout_status == 1 ? 'bg-success' : 'bg-danger'}}" name="product_checkout_status" onchange="document.getElementById('productForm{{$ogateway->id}}').submit();">
                                    <option value="1" {{$ogateway->product_checkout_status == 1 ? 'selected' : ''}}>Active</option>
                                    <option value="0" {{$ogateway->product_checkout_status == 0 ? 'selected' : ''}}>Deactive</option>
                                </select>
                                </form>
                              </td>
                              <td>
                                <form id="packageForm{{$ogateway->id}}" class="d-inline-block" action="{{route('admin.offline.status')}}" method="post">
                                @csrf
                                <input type="hidden" name="ogateway_id" value="{{$ogateway->id}}">
                                <input type="hidden" name="type" value="package">
                                <select class="form-control {{$ogateway->package_order_status == 1 ? 'bg-success' : 'bg-danger'}}" name="package_order_status" onchange="document.getElementById('packageForm{{$ogateway->id}}').submit();">
                                    <option value="1" {{$ogateway->package_order_status == 1 ? 'selected' : ''}}>Active</option>
                                    <option value="0" {{$ogateway->package_order_status == 0 ? 'selected' : ''}}>Deactive</option>
                                </select>
                                </form>
                              </td>
                              <td>{{$ogateway->serial_number}}</td>
                              <td>
                                <a class="btn btn-secondary btn-sm editbtn" href="#editModal" data-toggle="modal" data-ogateway_id="{{$ogateway->id}}" data-name="{{$ogateway->name}}" data-short_description="{{$ogateway->short_description}}" data-instructions="{{replaceBaseUrl($ogateway->instructions)}}" data-is_receipt="{{$ogateway->is_receipt}}" data-serial_number="{{$ogateway->serial_number}}">
                                    <span class="btn-label">
                                    <i class="fas fa-edit"></i>
                                    </span>
                                    Edit
                                </a>

                                 <form class="deleteform d-inline-block" action="{{route('admin.offline.gateway.delete')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="ogateway_id" value="{{$ogateway->id}}">
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
                  {{$ogateways->appends(['language' => request()->input('language')])->links()}}
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


<!-- Create Offline Gateway Modal -->
@includeIf('admin.gateways.offline.create')



<!-- Edit Package Modal -->
@includeIf('admin.gateways.offline.edit')


@endsection
@section('scripts')
<script>
   $(document).ready(function() {

       // make input fields RTL
       $("select[name='language_id']").on('change', function() {
           $(".request-loader").addClass("show");
           let url = "{{url('/')}}/admin/rtlcheck/" + $(this).val();
           // console.log(url);
           $.get(url, function(data) {
               $(".request-loader").removeClass("show");
               if (data == 1) {
                   $("form.modal-form input").each(function() {
                       if (!$(this).hasClass('ltr')) {
                           $(this).addClass('rtl');
                       }
                   });
                   $("form.modal-form select").each(function() {
                       if (!$(this).hasClass('ltr')) {
                           $(this).addClass('rtl');
                       }
                   });
                   $("form.modal-form textarea").each(function() {
                       if (!$(this).hasClass('ltr')) {
                           $(this).addClass('rtl');
                       }
                   });
                   $("form.modal-form .summernote").each(function() {
                       $(this).siblings('.note-editor').find('.note-editable').addClass('rtl text-right');
                   });

               } else {
                   $("form.modal-form input, form.modal-form select, form.modal-form textarea").removeClass('rtl');
                   $("form.modal-form .summernote").siblings('.note-editor').find('.note-editable').removeClass('rtl text-right');
               }
           })
       });
   });
</script>
@endsection
