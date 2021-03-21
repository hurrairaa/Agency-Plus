@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">
      @if (request()->path()=='admin/pending/orders')
        Pending
      @elseif (request()->path()=='admin/all/orders')
        All
      @elseif (request()->path()=='admin/processing/orders')
        Processing
      @elseif (request()->path()=='admin/completed/orders')
        Completed
      @elseif (request()->path()=='admin/rejected/orders')
        Rejcted
      @endif
      Orders
    </h4>
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
        <a href="#">Package Management</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">
          @if (request()->path()=='admin/pending/orders')
            Pending
          @elseif (request()->path()=='admin/all/orders')
            All
          @elseif (request()->path()=='admin/processing/orders')
            Processing
          @elseif (request()->path()=='admin/completed/orders')
            Completed
          @elseif (request()->path()=='admin/rejected/orders')
            Rejcted
          @endif
          Orders
        </a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-title">
                        @if (request()->path()=='admin/pending/orders')
                            Pending
                        @elseif (request()->path()=='admin/all/orders')
                            All
                        @elseif (request()->path()=='admin/processing/orders')
                            Processing
                        @elseif (request()->path()=='admin/completed/orders')
                            Completed
                        @elseif (request()->path()=='admin/rejected/orders')
                            Rejcted
                        @endif
                        Orders
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-2">
                    <button class="btn btn-danger float-right btn-md mr-2 d-none bulk-delete ml-2" data-href="{{route('admin.order.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
                    <form class="float-right"
                        @if (request()->path()=='admin/pending/orders')
                        action="{{route('admin.pending.orders')}}"
                        @elseif (request()->path()=='admin/all/orders')
                        action="{{route('admin.all.orders')}}"
                        @elseif (request()->path()=='admin/processing/orders')
                        action="{{route('admin.processing.orders')}}"
                        @elseif (request()->path()=='admin/completed/orders')
                        action="{{route('admin.completed.orders')}}"
                        @elseif (request()->path()=='admin/rejected/orders')
                        action="{{route('admin.rejected.orders')}}"
                        @endif
                    >
                        <input name="term" type="text" class="form-control" placeholder="Enter order number to search" value="{{request()->input('term')}}">
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($orders) == 0)
                <h3 class="text-center">NO ORDER FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">
                            <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">Order Number</th>
                        <th scope="col">Gateway</th>
                        <th scope="col">Package</th>
                        <th scope="col">Status</th>
                        <th scope="col">Receipt</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($orders as $key => $order)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{$order->id}}">
                          </td>
                          <td>#{{$order->order_number}}</td>
                          <td>{{$order->method}}</td>
                          <td>{{strlen(convertUtf8($order->package_title)) > 20 ? convertUtf8(substr($order->package_title, 0, 20)) . '...' : convertUtf8($order->package_title)}}</td>
                          <td>
                            <form id="statusForm{{$order->id}}" class="d-inline-block" action="{{route('admin.orders.status')}}" method="post">
                              @csrf
                              <input type="hidden" name="order_id" value="{{$order->id}}">
                              <select class="form-control form-control-sm
                              @if ($order->status == 0)
                                bg-warning
                              @elseif ($order->status == 1)
                                bg-primary
                              @elseif ($order->status == 2)
                                bg-success
                              @elseif ($order->status == 3)
                                bg-danger
                              @endif
                              " name="status" onchange="document.getElementById('statusForm{{$order->id}}').submit();">
                                <option value="0" {{$order->status == 0 ? 'selected' : ''}}>Pending</option>
                                <option value="1" {{$order->status == 1 ? 'selected' : ''}}>Processing</option>
                                <option value="2" {{$order->status == 2 ? 'selected' : ''}}>Completed</option>
                                <option value="3" {{$order->status == 3 ? 'selected' : ''}}>Rejected</option>
                              </select>
                            </form>
                          </td>
                          <td>
                            @if (!empty($order->receipt))
                              <a class="btn btn-sm btn-info" href="#" data-toggle="modal" data-target="#receiptModal{{$order->id}}">Show</a>
                            @else
                              -
                            @endif
                          </td>
                          <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Select Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <a href="#" class="editbtn dropdown-item" data-target="#mailModal" data-toggle="modal" data-email={{$order->email}}> Send Mail</a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#detailsModal{{$order->id}}" target="_blank"> Details</a>
                                  <a class="dropdown-item" target="_blank" href="{{asset('assets/front/invoices/'.$order->invoice)}}"> Invoice</a>
                                    <form class="deleteform d-block" action="{{route('admin.package.order.delete')}}" method="post">
                                      @csrf
                                      <input type="hidden" name="order_id" value="{{$order->id}}">
                                      <button type="submit" class="deletebtn">
                                        Delete
                                      </button>
                                    </form>
                                </div>
                            </div>
                          </td>
                        </tr>


                        {{-- Receipt Modal --}}
                        <div class="modal fade" id="receiptModal{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Receipt Image</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <img src="{{asset('assets/front/receipt/' . $order->receipt)}}" alt="Receipt" width="100%">
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>

                        @includeif('admin.package.order-details')
                      @endforeach
                    </tbody>
                  </table>
                </div>

                <!-- Send Mail Modal -->
                <div class="modal fade" id="mailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Send Mail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form id="ajaxEditForm" class="" action="{{route('admin.orders.mail')}}" method="POST">
                          @csrf
                          <div class="form-group">
                            <label for="">Client Mail **</label>
                            <input id="inemail" type="text" class="form-control" name="email" value="" placeholder="Enter email">
                            <p id="eerremail" class="mb-0 text-danger em"></p>
                          </div>
                          <div class="form-group">
                            <label for="">Subject **</label>
                            <input id="insubject" type="text" class="form-control" name="subject" value="" placeholder="Enter subject">
                            <p id="eerrsubject" class="mb-0 text-danger em"></p>
                          </div>
                          <div class="form-group">
                            <label for="">Message **</label>
                            <textarea id="inmessage" class="form-control summernote" name="message" placeholder="Enter message" data-height="150"></textarea>
                            <p id="eerrmessage" class="mb-0 text-danger em"></p>
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="updateBtn" type="button" class="btn btn-primary">Send Mail</button>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="d-inline-block mx-auto">
                {{ $orders->appends(['term' => request()->input('term')])->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
