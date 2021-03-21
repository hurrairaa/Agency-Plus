<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Language</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form id="ajaxForm" class="" action="{{route('admin.language.store')}}" method="POST">
          @csrf
          <input type="hidden" id="image" name="" value="">
          <div class="form-group">
            <label for="">Name **</label>
            <input type="text" class="form-control" name="name" placeholder="Enter name" value="">
            <p id="errname" class="mb-0 text-danger em"></p>
          </div>
          <div class="form-group">
            <label for="">Code **</label>
            <input type="text" class="form-control" name="code" placeholder="Enter code" value="">
            <p id="errcode" class="mb-0 text-danger em"></p>
          </div>
          <div class="form-group">
            <label for="">Direction **</label>
            <select name="direction" class="form-control">
                <option value="" selected disabled>Select a Direction</option>
                <option value="0">LTR (Left to Right)</option>
                <option value="1">RTL (Right to Left)</option>
            </select>
            <p id="errdirection" class="mb-0 text-danger em"></p>
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
