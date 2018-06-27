<!-- Modal -->
<div class="modal fade" id="deleteModal{{$category->id}}" role="dialog">
  <div>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Category</h4>
      </div>
      <div class="modal-body text-center">
        <h4>Are you sure you want to delete this category?</h4>
        <form style="display:inline-block;" class="" action="{{route('admin.category.delete', $category->id)}}" method="post">
          {{csrf_field()}}
          <button type="submit" class="btn btn-primary">Yes</button>
        </form>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
