{{-- @push('scripts') --}}
  <script>
    function showHideGig(e, serviceID) {
      console.log(serviceID);
      console.log(e.target.innerHTML);
      var fd = new FormData();
      fd.append('serviceID', serviceID);
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      if(e.target.innerHTML == 'Hide') {
        document.getElementById('hideShowBtn'+serviceID).innerHTML = '<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>';

        $.ajax({
          url: '{{route('gigManagement.gigHide')}}',
          type: 'POST',
          data: fd,
          contentType: false,
          processData: false,
          success: function(data) {
            console.log(data);
            if (data == "success") {
              document.getElementById('hideShowBtn'+serviceID).innerHTML = 'Show';
            }
            if (data != "success") {
              swal('Sorry!', 'This is Demo version. You can not change anything.', 'error');
            }
          }
        });
      } else {
        document.getElementById('hideShowBtn'+serviceID).innerHTML = '<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>';

        $.ajax({
          url: '{{route('gigManagement.gigShow')}}',
          type: 'POST',
          data: fd,
          contentType: false,
          processData: false,
          success: function(data) {
            console.log(data);
            if (data == "success") {
              document.getElementById('hideShowBtn'+serviceID).innerHTML = 'Hide';
            }
            if (data != "success") {
              swal('Sorry!', 'This is Demo version. You can not change anything.', 'error');
            }
          }
        });
      }

    }
  </script>
  <script>
    function changeFeatureStatus(e, serviceID) {
      console.log(serviceID);
      var featureStatus;
      if (e.target.innerHTML == 'Feature') {
        document.getElementById('featureStatusBtn'+serviceID).innerHTML = 'Unfeature';
        featureStatus = 1;
      } else {
        document.getElementById('featureStatusBtn'+serviceID).innerHTML = 'Feature';
        featureStatus = 0;
      }
      var fd = new FormData();
      fd.append('serviceID', serviceID);
      fd.append('featureStatus', featureStatus);
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      document.getElementById('featureStatusBtn'+serviceID).innerHTML = '<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>';

      $.ajax({
        url: '{{route('gigManagement.gigFeatureStatusChange')}}',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: function(data) {
          console.log(data);
          if (data == "success") {
            if(featureStatus == 1) {
              document.getElementById('featureStatusBtn'+serviceID).innerHTML = 'Unfeature'
            } else {
              document.getElementById('featureStatusBtn'+serviceID).innerHTML = 'Feature'
            }
          }
          if(data != "success") {
            swal('Sorry!', 'This is Demo version. You can not change anything.', 'error');
          }
        }
      });
    }
</script>
{{-- @endpush --}}
