
<div class="modal fade" id="EditPostModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content... -->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Post</h4>
      </div>
      <div class="modal-body">
        <form id="editPostSubmitFormId" class="row" style="padding:0px 20px;" method="POST" onsubmit="event.preventDefault();">
           {{csrf_field()}}
           <input id="postID" type="hidden" name="postID" value="">
           <textarea name="content" id="editPostTextarea" style="width:100%;height:150px;" required>{{$post->content}}</textarea>
           <br>
           <div class="text-center">
              <button class="btn btn-primary" type="button" onclick="updatePost()">UPDATE</button>
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
    function updatePost() {
      var form = document.getElementById('editPostSubmitFormId');
      var fd = new FormData(form);
      var postID = fd.get('postID');
      $.ajax({
        url: '{{route('posts.update')}}',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: function(data) {
          console.log(data);
          if(data == "success") {
            $("#postContent"+postID).load(location.href + " #postContent"+postID);
            $("#EditPostModal").modal('hide');
          }
        }
      });
    }
  </script>
@endpush
