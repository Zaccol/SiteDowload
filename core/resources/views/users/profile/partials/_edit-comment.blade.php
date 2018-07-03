
<div class="modal fade" id="EditCommentModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content... -->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Post</h4>
      </div>
      <div class="modal-body">
        <form id="editCommentSubmitFormId" class="row" onsubmit="event.preventDefault();" style="padding:0px 20px;" method="POST">
           {{csrf_field()}}
           <input id="commentID" type="hidden" name="commentID" value="">
           <input id="editCommentInput" autocomplete="off" class="form-control" type="text" name="editCommentInput" value="">
           <br>
           <div class="text-center">
              <button class="btn btn-primary" type="button" onclick="updateComment()">UPDATE</button>
           </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

@push('scripts')
  <script>
      function updateComment() {
        var form = document.getElementById('editCommentSubmitFormId');
        var fd = new FormData(form);
        var commentID = fd.get('commentID');
        $.ajax({
          url: '{{route('comments.update')}}',
          type: 'POST',
          data: fd,
          contentType: false,
          processData: false,
          success: function(data) {
            console.log(data);
            if(data == "success") {
              $("#EditCommentModal").modal('hide');
              $("#commentContent"+commentID).load(location.href + " #commentContent"+commentID);
            }
          }
        });
      }
  </script>
@endpush
