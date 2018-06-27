<!-- Modal -->
<div class="modal fade" id="addModal" role="dialog">
  <div>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Category</h4>
      </div>
      <div class="modal-body">
        <form class="" action="{{route('admin.category.store')}}" method="post">
          {{csrf_field()}}
          <div class="form-group">
            <label for="">Category Name:</label>
            <input name="category" type="text" class="form-control" id="" placeholder="Category Name">
          </div>
          <div class="row text-center">
            <button type="submit" class="btn btn-primary">Add</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
