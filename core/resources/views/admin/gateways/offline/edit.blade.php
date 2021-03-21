<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLongTitle">Edit Gateway</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <div class="modal-body">
             <form id="ajaxEditForm" class="" action="{{route('admin.gateway.offline.update')}}" method="POST">
                @csrf
                <input id="inogateway_id" type="hidden" name="ogateway_id" value="">
                <div class="form-group">
                   <label for="">Name **</label>
                   <input id="inname" type="text" class="form-control" name="name" value="" placeholder="Enter name">
                   <p id="eerrname" class="mb-0 text-danger em"></p>
                </div>

                <div class="form-group">
                    <label for="">Short Description</label>
                    <textarea id="inshort_description" class="form-control" name="short_description" rows="3" cols="80" placeholder="Enter short description"></textarea>
                    <p id="eerrshort_description" class="mb-0 text-danger em"></p>
                 </div>

                 <div class="form-group">
                    <label for="">Instructions</label>
                    <textarea id="ininstructions" class="form-control summernote" name="instructions" rows="3" cols="80" placeholder="Enter instructions" data-height="150"></textarea>
                 </div>

                 <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label>Receipt Image **</label>
                        <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="is_receipt" value="1" class="selectgroup-input" >
                                    <span class="selectgroup-button">Active</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="is_receipt" value="0" class="selectgroup-input">
                                    <span class="selectgroup-button">Deactive</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                           <label for="">Serial Number **</label>
                           <input id="inserial_number" type="number" class="form-control ltr" name="serial_number" value="" placeholder="Enter Serial Number">
                           <p id="eerrserial_number" class="mb-0 text-danger em"></p>
                           <p class="text-warning"><small>The higher the serial number is, the later the package will be shown everywhere.</small></p>
                        </div>
                    </div>
                 </div>
             </form>
          </div>
          <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             <button id="updateBtn" type="button" class="btn btn-primary">Save Changes</button>
          </div>
       </div>
    </div>
 </div>
