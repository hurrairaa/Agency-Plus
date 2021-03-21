<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Roles</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="ajaxForm" class="" action="{{route('admin.role.store')}}" method="POST">
          @csrf
          <div class="form-group">
            <label for="">Role Name **</label>
            <input class="form-control" name="name" placeholder="Enter name">
            <p id="errname" class="mb-0 text-danger em"></p>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="submitBtn" type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
