<h3 style="margin-top:10px;">Comments</h3>
@push('styles')
<style media="screen">
   .nicEdit-main {
   background-color: white;
   resize:vertical;
   margin: 0px !important;
   }
   .toggleComments {
   display: none;
   }
</style>
@endpush


<div id="commentsContainer" class="comments-container">
   @auth
   <form autocomplete="off" id="postSubmitFormId" onsubmit="submitPost(event, {{$user->id}})" class="row" style="padding:0px 20px;" method="POST">
      {{csrf_field()}}
      <input type="hidden" name="postedOnUserId" value="{{$user->id}}">
      <textarea name="content" id="postTextarea" style="width:100%;height:150px;"></textarea>
      <br>
      <div class="text-center">
         <input style="width:200px;" class="btn btn-primary" type="submit" name="" value="POST">
      </div>
   </form>
   @endauth
   <br>
   <div id="postCommentContainer">
      {{-- All the posts --}}
      @foreach ($posts as $post)
      {{-- Posts --}}
      <div class="media well" id="postCommentContainer{{$post->id}}">
         <div class="comment-propic-container">
            <img src="{{asset('assets/users/propics/'.$post->user->pro_pic)}}" class="media-object" style="width:45px;height:45px;border-radius:50%;">
         </div>
         <div class="media-body">
            <div id="post{{$post->id}}">
               <h4 class="media-heading"><span>{{$post->user->firstname}} {{$post->user->lastname}}</span> <small><i>Posted on {{$post->created_at}}</i></small></h4>
               <p id="postContent{{$post->id}}" class="postContent">{!! $post->content !!}</p>
               <p>
                  @auth
                  @if (Auth::user()->id == $post->user->id)
                  <a href="#" style="margin-right:10px;" onclick="showEditPostModal(event, {{$post->id}})">Edit</a>
                  <a href="#" style="margin-right:10px;" onclick="deletePost(event, {{$post->id}})">Delete</a>
                  @endif
                  @endauth
                  @if (count($post->comments) > 1)
                  <a href="#" onclick="toggleComments(event,{{$post->id}})">View Previous Comments</a>
                  @endif
               </p>
               <!-- Edit Post Modal... -->
               @includeif('users.profile.partials._edit-post')
               <!-- Nested media object -->
               {{-- if there is only one content under this post... --}}
               @if (count($post->comments) == 1)
               {{-- Single Comment... --}}
               <div class="media" id="comment{{$post->comments[0]->id}}">
                  <div class="comment-propic-container">
                     <img src="{{asset('assets/users/propics/' . $post->comments[0]->user->pro_pic)}}" class="media-object" style="width:45px;height:45px;border-radius:50%;">
                  </div>
                  <div class="media-body">
                     <h4 class="media-heading"><span>{{$post->comments[0]->user->firstname}} {{$post->comments[0]->user->lastname}}</span> <small><i>Posted on February 19, 2016</i></small></h4>
                     <p style="color:black;" id="commentContent{{$post->comments[0]->id}}">{{$post->comments[0]->comment}}</p>
                     @auth
                     @if (Auth::user()->id == $post->comments[0]->user->id)
                     <p>
                        <a href="#" style="margin-right:10px;" onclick="showEditCommentModal(event, {{$post->comments[0]->id}})">Edit</a>
                        <a href="#" style="margin-right:10px;" onclick="deleteComment(event, {{$post->comments[0]->id}})">Delete</a>
                     </p>
                     @endif
                     @endauth
                  </div>
               </div>
               {{-- if there is more than one content under this post... --}}
               @elseif (count($post->comments) > 1 && count($post->comments) != 0)
               <div class="toggleComments" id="togglableComments{{$post->id}}">
                  @foreach ($post->comments as $comment)
                  {{-- if this is not the last loop of the comments --}}
                  @if (!$loop->last)
                  {{-- All the comments except the last comment... --}}
                  <div class="media" id="comment{{$comment->id}}">
                     <div class="comment-propic-container">
                        <img src="{{asset('assets/users/propics/' . $comment->user->pro_pic)}}" class="media-object" style="width:45px;height:45px;border-radius:50%;">
                     </div>
                     {{-- Comment Content --}}
                     <div class="media-body">
                        <h4 class="media-heading"><span>{{$comment->user->firstname}} {{$comment->user->lastname}}</span> <small><i>Posted on February 19, 2016</i></small></h4>
                        <p style="color:black;" id="commentContent{{$comment->id}}">{{$comment->comment}}</p>
                        @auth
                        @if (Auth::user()->id == $comment->user->id)
                        <p>
                           <a href="#" style="margin-right:10px;" onclick="showEditCommentModal(event, {{$comment->id}})">Edit</a>
                           <a href="#" style="margin-right:10px;" onclick="deleteComment(event, {{$comment->id}})">Delete</a>
                        </p>
                        @endif
                        @endauth
                     </div>
                  </div>
                  {{-- if this is the last loop of the comments --}}
                  @else
               </div>
               {{-- Last Comment of the comments loop --}}
               <div class="media" id="comment{{$comment->id}}">
                  <div class="comment-propic-container">
                     <img src="{{asset('assets/users/propics/' . $comment->user->pro_pic)}}" class="media-object" style="width:45px;height:45px;border-radius:50%;">
                  </div>
                  {{-- Comment Content --}}
                  <div class="media-body">
                     <h4 class="media-heading"><span>{{$comment->user->firstname}} {{$comment->user->lastname}}</span> <small><i>Posted on February 19, 2016</i></small></h4>
                     <p style="color:black;" id="commentContent{{$comment->id}}">{{$comment->comment}}</p>
                     @auth
                     @if (Auth::user()->id == $comment->user->id)
                     <p>
                        <a href="#" style="margin-right:10px;" onclick="showEditCommentModal(event, {{$comment->id}})">Edit</a>
                        <a href="#" style="margin-right:10px;" onclick="deleteComment(event, {{$comment->id}})">Delete</a>
                     </p>
                     @endif
                     @endauth
                  </div>
               </div>
               @endif
               @endforeach
               @endif
            </div>
            @auth
            <form autocomplete="off" method="post" onsubmit="storeComment(event, {{$post->id}})" id="commentForm{{$post->id}}">
               {{csrf_field()}}
               <input type="hidden" name="postID" value="{{$post->id}}" />
               <input type="text" name="comment" value="" style="width:95%;color:black;" required>
            </form>
            @endauth
         </div>
      </div>
      @endforeach
   </div>
   <div class="row text-center">
      {{$posts->links()}}
   </div>
</div>
@includeif('users.profile.partials._edit-comment')

@auth
{{-- Storing Post AJAX Request... --}}
@push('scripts')
<script>
   function submitPost(e, userID) {
     e.preventDefault();
     var postSubmitForm = document.getElementById('postSubmitFormId');
     var fd = new FormData(postSubmitForm);
     // getting post content...
     $.ajaxSetup({
         headers: {
             'X-CSRF-Token': $('meta[name=_token]').attr('content')
         }
     });
     // if()
     $.ajax({
       url: '{{route('posts.store')}}',
       type: 'POST',
       data: fd,
       contentType: false,
       processData: false,
       success: function(data) {
         if(data == "success") {
           document.getElementById('postSubmitFormId').reset();
           $("#postCommentContainer").load(location.href + " #postCommentContainer");
         }
       }
     });
   }
</script>
@endpush
{{-- Store Commment AJAX Request... --}}
@push('scripts')
<script>
   function storeComment(e, postID) {
       e.preventDefault();
       var form = document.getElementById('commentForm'+postID);
       var fd = new FormData(form);
       $.ajax({
         url: '{{route('comments.store')}}',
         type: 'POST',
         data: fd,
         contentType: false,
         processData: false,
         success: function(data) {
             document.getElementById('commentForm'+postID).reset();
             $("#post"+postID).append("<div class='media' id='comment"+data.id+"'><div class='comment-propic-container'><img src='{{asset('assets/users/propics/'. Auth::user()->pro_pic)}}' class='media-object' style='width:45px;height:45px;border-radius:50%;'></div><div class='media-body'><h4 class='media-heading'><span>{{Auth::user()->firstname}} {{Auth::user()->lastname}}</span> <small><i>Posted on February 19, 2016</i></small></h4><p style='color:black;' id='commentContent"+data.id+"'>"+data.comment+"</p><p><a href='#' style='margin-right:10px;' onclick='showEditCommentModal(event, "+data.id+")'>Edit</a><a href='#' style='margin-right:10px;' onclick='deleteComment(event, "+data.id+")'>Delete</a></p></div></div>");
         }
       });
   }
</script>
@endpush

{{-- Show Existing Post Content in Modal --}}
@push('scripts')
<script>
   function showEditPostModal(e, postID) {
     e.preventDefault();
     var fd = new FormData();
     fd.append('postID', postID);
     $.ajaxSetup({
         headers: {
             'X-CSRF-Token': $('meta[name=_token]').attr('content')
         }
     });
     $.ajax({
        url: '{{route('posts.edit')}}',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: function(data) {
            $("#EditPostModal").modal('show');
            document.getElementById('postID').value = data.id;
            document.getElementById('editPostTextarea').value = data.content;
            console.log(data);
        }
     });
   }
</script>
@endpush
{{-- Show Existing Comment Content in Modal --}}
@push('scripts')
<script>
   function showEditCommentModal(e, commentID) {
     e.preventDefault();
     // $.get(
     //     '/freelancing-site/comments/edit/'+commentID,
     //     function(data) {
     //         $("#EditCommentModal").modal('show');
     //         document.getElementById('commentID').value = data.id;
     //         document.getElementById('editCommentInput').value = data.comment;
     //         console.log(data);
     //     }
     // );
     var fd = new FormData();
     fd.append('commentID', commentID);
     $.ajaxSetup({
         headers: {
             'X-CSRF-Token': $('meta[name=_token]').attr('content')
         }
     });
     $.ajax({
       url: '{{route('comments.edit')}}',
       type: 'POST',
       data: fd,
       contentType: false,
       processData: false,
       success: function(data) {
         $("#EditCommentModal").modal('show');
         document.getElementById('commentID').value = data.id;
         document.getElementById('editCommentInput').value = data.comment;
         console.log(data);
       }
     })
   }
</script>
@endpush
{{-- Delete Comment AJAX Request --}}
@push('scripts')
<script>
   function deleteComment(e, commentID) {
     e.preventDefault();
     var fd = new FormData();
     fd.append('commentID', commentID);
     $.ajaxSetup({
         headers: {
             'X-CSRF-Token': $('meta[name=_token]').attr('content')
         }
     });
     $.ajax({
       url: '{{route('comments.delete')}}',
       type: 'POST',
       data: fd,
       contentType: false,
       processData: false,
       success: function(data) {
           if(data == 'success') {
             $("#comment"+commentID).remove();
           }
       }
     })
   }
</script>
@endpush
{{-- Delete Post AJAX Request... --}}
@push('scripts')
<script>
   function deletePost(e, postID) {
     e.preventDefault();
     var fd = new FormData();
     fd.append('postID', postID);
     $.ajaxSetup({
         headers: {
             'X-CSRF-Token': $('meta[name=_token]').attr('content')
         }
     });
     $.ajax({
        url: '{{route('posts.delete')}}',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: function(data) {
           if(data == 'success') {
              $("#postCommentContainer"+postID).remove();
            }
        }
     })
   }
</script>
@endpush
@endauth
{{-- Toggle Comments Javascript --}}
@push('scripts')
<script>
   function toggleComments(e,postID) {
     e.preventDefault();
     $("#togglableComments"+postID).toggle();
   }
</script>
@endpush
