<h3 class="text-center text-warning">Completed Orders</h3>
<table class="table">
  <thead>
    <tr>
      <th>Title</th>
      <th>Description</th>
      <th>Messages</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($comOrders as $comOrder)
      <tr>
        <td>
          <a style="text-decoration:underline;" href="{{route('services.show',[$comOrder->service->id, Auth::user()->id])}}">{{(strlen($comOrder->service->service_title)>40) ? substr($comOrder->service->service_title, 0, 40) . '...' : $comOrder->service->service_title }}</a>
        </td>
        <td>
          <p>What is Lorem Ipsum?Lorem Ipsum is simply dum...</p>
        </td>
        <td>
          <a href="{{route('seller.sellerToBuyerMessages', $comOrder->id)}}" target="_blank" class="btn btn-warning">View</a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
<div class="row text-center">
  {{$comOrders->links()}}
</div>
