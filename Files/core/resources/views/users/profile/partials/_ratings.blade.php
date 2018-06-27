<h3 style="margin-top:10px;">Ratings</h3>
@foreach ($ratings as $rating)
  <div class="well">
    <div class="media">
        <div class="media-middle rating-propic-container">
            <img style="height:100%;width:100%;border-radius:50%;" src="{{asset('assets/users/propics/'.$rating->pro_pic)}}" class="media-object">
        </div>
        <div class="media-body">
          <h4 class="media-heading">{{$rating->firstname}} {{$rating->lastname}}</h4>
          <p>{{$rating->rating}}</p>
        </div>
    </div>
  </div>
@endforeach
<div class="row text-center">
  {{$ratings->links()}}
</div>
