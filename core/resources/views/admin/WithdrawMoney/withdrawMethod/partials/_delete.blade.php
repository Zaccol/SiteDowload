

@push('scripts')
   <script>
      function enableDisableWM(wmID) {
         console.log(document.getElementById('enableDisableBtnID'+wmID).innerHTML);
         var fd = new FormData();
         fd.append('wmID', wmID);
         $.ajaxSetup({
         headers: {
              'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
         }
         });
         if (document.getElementById('enableDisableBtnID'+wmID).innerHTML == 'Disable') {
            $.ajax({
               url: '{{route('withdrawMethod.destroy')}}',
               type: 'POST',
               data: fd,
               contentType: false,
               processData: false,
               success: function(data) {
                  console.log(data);
                  if (data == "success") {
                     document.getElementById('enableDisableBtnID'+wmID).innerHTML = 'Enable';
                  }
                  if(data != "success") {
                    swal('Sorry!', 'This is Demo version. You can not change anything.', 'error');
                  }
               }
            });
         } else {
            $.ajax({
               url: '{{route('withdrawMethod.enable')}}',
               type: 'POST',
               data: fd,
               contentType: false,
               processData: false,
               success: function(data) {
                  console.log(data);
                  if (data == "success") {
                     document.getElementById('enableDisableBtnID'+wmID).innerHTML = 'Disable';
                  }
                  if(data != "success") {
                    swal('Sorry!', 'This is Demo version. You can not change anything.', 'error');
                  }
               }
            });
         }

      }
   </script>
@endpush
