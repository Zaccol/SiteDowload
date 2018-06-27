<h3 class="text-center text-warning">Current Orders</h3>
<table class="table">
  <thead>
    <tr>
      <th style="">Title</th>
      <th style="">Description</th>
      <th style="">Messages</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rejOrders as $rejOrder)
      <tr>
        <td>
          <a style="text-decoration:underline;" href="{{route('services.show',[$rejOrder->service->id, Auth::user()->id])}}">{{(strlen($rejOrder->service->service_title)>40) ? substr($rejOrder->service->service_title, 0, 40) . '...' : $rejOrder->service->service_title }}</a>
        </td>
        <td>
          <p style="">
            {!!(strlen(strip_tags($rejOrder->service->description))>120) ? substr(strip_tags($rejOrder->service->description), 0, 100) . '...' : strip_tags($rejOrder->service->description) !!}
          </p>
        </td>
        <td>
          <a href="{{route('seller.sellerToBuyerMessages', $rejOrder->id)}}" target="_blank" class="btn btn-warning">View</a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
<div class="row text-center">
  {{$rejOrders->links()}}
</div>
