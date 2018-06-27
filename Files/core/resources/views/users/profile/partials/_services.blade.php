<h3 style="margin-top:10px;">Services</h3>
<div class="services-container">
  <div class="row">
    @foreach ($services as $service)
      <div class="col-md-4">
        <div class="panel">
          <div class="panel-heading">
              <img src="{{asset('assets/users/service_images/' . $service->serviceImages()->first()->image_name)}}" alt="">
          </div>
          <div class="panel-body">
            <h5><a href="{{route('services.show', [$service->id, $user->id])}}">{{(strlen($service->service_title) > 35) ? substr($service->service_title, 0, 35) . '...' : $service->service_title}}</a></h5>
            <p>
                <span class="pull-left"><small>{{$user->username}}</small></span>
                <span class="pull-right"><small>{{$service->price}}{{$gs->base_curr_symbol}}</small></span>
            </p>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <div class="row text-center">
    {{$services->links()}}
  </div>
</div>
