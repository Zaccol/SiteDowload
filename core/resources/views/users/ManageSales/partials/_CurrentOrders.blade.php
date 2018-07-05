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
    @foreach ($currOrders as $currOrder)
      <tr>
        <td>
          <a style="text-decoration:underline;" href="{{route('services.show',[$currOrder->service->id, Auth::user()->id])}}">{{(strlen($currOrder->service->service_title)>40) ? substr($currOrder->service->service_title, 0, 40) . '...' : $currOrder->service->service_title }}</a>
        </td>
        <td>
          <p style="">
            {!!(strlen(strip_tags($currOrder->service->description))>120) ? substr(strip_tags($currOrder->service->description), 0, 100) . '...' : strip_tags($currOrder->service->description) !!}
          </p>
        </td>
        <td>
          <a href="{{route('seller.sellerToBuyerMessages', $currOrder->id)}}" target="_blank" class="btn btn-warning">View</a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
<div class="row text-center">
  {{$currOrders->links()}}
</div>
