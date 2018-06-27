@extends('users.layout.master')

@section('title', 'Create Service')

{{-- All necessary JS for NIC Editor --}}
@push('nic-editor-scripts')
  <script src="{{asset('assets/admin/js/nic-edit/nicEdit.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
    bkLib.onDomLoaded(function() {
          new nicEditor({iconsPath : "{{asset('assets/admin/js/nic-edit/nicEditorIcons.gif')}}"}).panelInstance('description');
    });
  </script>
  <script type="text/javascript">
    bkLib.onDomLoaded(function() {
          new nicEditor({iconsPath : "{{asset('assets/admin/js/nic-edit/nicEditorIcons.gif')}}"}).panelInstance('introToBuyer');
    });
  </script>
@endpush

@push('styles')
  <style media="screen">
    .nicEdit-main{
      background-color: white;
      resize:vertical;
      margin: 0px !important;
    }
    input:not(.updateBtn) {
      margin: 0px !important;
      background-color: white !important;
    }
    .login-admin {
      padding:0px 100px;
    }
    @media screen and (max-width: 500px) {
      .login-admin {
        padding:0px;
      }
    }
  </style>
@endpush

@section('content')

          <div class="login-admin" style="">
            <div class="login-header">
              <h2 style="">Create a service</span></h2>
            </div>
            <div class="login-form">
              @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                  {{session('success')}}
                </div>
              @endif
              <form onsubmit="storeService(event)" id="storeServiceForm" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <strong style="">Service Title *</strong><br>
                {{-- Service Title... --}}
                <input style="height:40px;" type="text" name="serviceTitle" placeholder="Service Title" value="">
                <span class="error-messages" style="color:red;"></span>
                <br><br>
                {{-- Price... --}}
                <strong style="">Price (in {{$gs->base_curr_text}}) *</strong><br>
                <input style="height:40px;" type="text" name="price" placeholder="Price in {{$gs->base_curr_text}}" value="">
                <span class="error-messages" style="color:red;"></span>
                <br><br>
                {{-- Category... --}}
                <strong style="">Category *</strong><br>
                <select class="" name="category" style="width:100%;height:40px;padding-left:35px;">
                  <option value="" disabled selected>Select a category</option>
                  @foreach ($categories as $category)
                  <option value="{{$category->id}}">{{$category->name}}</option>
                  @endforeach
                </select>
                <span class="error-messages" style="color:red;"></span>
                <br><br>
                {{-- Maximum Days to Complete... --}}
                <strong style="">Maximum Days to Complete *</strong><br>
                <input style="height:40px;" type="text" name="maxDaysToComplete" placeholder="Maximum Days to Complete" value="">
                <span class="error-messages" style="color:red;"></span>
                <br><br>
                {{-- Image... --}}
                <div class="" id="serviceImagesDiv">
                  <img class="serviceImages-cont" width="100" src="" alt="">
                  <img class="serviceImages-cont" width="100" src="" alt="">
                  <img class="serviceImages-cont" width="100" src="" alt="">
                </div>
                <strong style="">Image *</strong><br>
                <label class="btn btn-success" style="width:200px;cursor:pointer;margin-left:-2px;margin-top:5px;">
                  <input id="serviceImages" name="images[]" style="display:none;" type="file" multiple />Add Images
                </label>
                <div class="">
                  <p style="margin:0px;">[Choose maximum 3 images]</p>
                  <p style="margin:0px;">[Acceptable Formats: .png, .jpg, .jpeg]</p>
                  <p style="margin:0px;">[Images will be resized to 760X400]</p>
                </div>

                <p style="margin:0px;"><span class="error-messages" style="color:red;"></span></p>
                <span class="error-messages" style="color:red;"></span>
                <span class="error-messages" style="color:red;"></span>
                <br>
                {{-- Tags... --}}
                <strong style="">Tags *</strong><br>
                <div id="tags">
                  {{-- <button type="button" class="btn btn-primary">HTML</button> --}}
                  {{-- All the dynamic buttons will be added here... --}}
                </div>
                {{-- name="tagInput" --}}
                <input id="tagInput" onkeypress="addTags(event,this.value)" type="text" style="height:40px;width:200px;" placeholder="Tags" value="">
                <span style="">[You can add maximum 5 tags]</span><br>
                <span class="error-messages" style="color:red;"></span>
                <br>
                {{-- Description... --}}
                <strong style="">Description *</strong><br>
                <textarea id="description" rows="10" cols="80" style="width:100%;"></textarea>
                <span class="error-messages" style="color:red;"></span>
                <br>
                {{-- Introductions to Buyer... --}}
                <strong style="">Introductions to Buyer *</strong><br>
                <textarea id="introToBuyer" rows="10" style="width:100%;"></textarea>
                <span class="error-messages" style="color:red;"></span>
                <br>
                {{-- Create Button... --}}
                <input id="createBtn" class="updateBtn" type="submit" name="submit" value="CREATE">
              </form>
            </div>
          </div>

          @component('users.components.success')
          @endcomponent
@endsection

@push('scripts')
  <script>
      var tagsArr = [];

      // adding tags to UI dynamically and adding tags to 'tagsArr'...
      function addTags(e, tag) {
        if(e.keyCode == 13) {
          e.preventDefault();
          if(e.target.value.length != 0 && tagsArr.length != 5) {
            // =======Adding tags dynamically ========== //
            var tags = document.getElementById('tags');

            // creating button...
            var button = document.createElement('button');
            button.setAttribute('type', 'button');
            button.setAttribute('class', 'btn btn-primary');
            button.setAttribute('style', 'margin-right:5px');

            // adding button text to button...
            var buttonText = document.createTextNode(tag);
            button.appendChild(buttonText);

            // adding close icon to button...
            var closeIcon = document.createElement('i');
            closeIcon.setAttribute('class', 'fa fa-close');
            closeIcon.setAttribute('style', 'margin-left:3px');
            closeIcon.setAttribute('onclick', 'removeTag(event)');
            button.appendChild(closeIcon);

            // adding buttons under 'tags' div...
            tags.appendChild(button);
            // =======Adding tags dynamically ========== //
            document.getElementById('tagInput').value = '';
            console.log('Enter pressed');
            tagsArr.push(tag);
            console.log(tagsArr);
          }
        }

      }

      // Removing tags from UI dynamically and removing from tagsArr...
      function removeTag(e) {
        for (var i = 0; i < tagsArr.length; i++) {
          if (tagsArr[i] == e.target.parentElement.innerText) {
              tagsArr.splice(i, 1);
              e.target.parentElement.remove();
              console.log(tagsArr);
              break;
          }
        }
      }

      // storing service to database...
      function storeService(e) {
        e.preventDefault();
        var storeServiceForm = document.getElementById('storeServiceForm');
        // getting description content...
        var descriptionElement = new nicEditors.findEditor('description');
        description = descriptionElement.getContent();
        // getting Introductions to buyer content...
        var introToBuyerElement = new nicEditors.findEditor('introToBuyer');
        introToBuyer = introToBuyerElement.getContent();
        var fd = new FormData(storeServiceForm);
        fd.append('tags', JSON.stringify(tagsArr));
        fd.append('description', description);
        fd.append('introToBuyer', introToBuyer);
        // console.log(tagsArr);
        document.getElementById('createBtn').innerHTML = '<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>';
        $.ajax({
          url: '{{route('services.store')}}',
          type: 'POST',
          data: fd,
          contentType: false,
          processData: false,
          success: function(data) {
            document.getElementById('createBtn').innerHTML = 'CREATE';
            console.log(data);

            var em = document.getElementsByClassName("error-messages");
            // after returning from the controller we are clearing the
            // previous error messages...
            for(i=0; i<em.length; i++) {
              em[i].innerHTML = '';
            }
            if(data == 'success') {
              document.getElementById('storeServiceForm').reset();
              // making NIC edit textarea null after submitting form successfully...
              descriptionElement.setContent('');
              introToBuyerElement.setContent('');
              document.getElementById('tags').innerHTML = '';
              document.getElementById('serviceImagesDiv').innerHTML = '';
              tagsArr = [];
              var snackbarSuccess = document.getElementById('snackbarSuccess');
              snackbarSuccess.innerHTML = "Service added successfully!";
              snackbarSuccess.className = "show";
              setTimeout(function() {
                snackbarSuccess.className = snackbarSuccess.className.replace("show", "");
              }, 3000);
            }

            // Showing error messages in the HTML...
            if(typeof data.error != 'undefined') {
              if(typeof data.serviceTitle != 'undefined') {
                em[0].innerHTML = data.serviceTitle[0];
              }
              if(typeof data.price != 'undefined') {
                em[1].innerHTML = data.price[0];
              }
              if(typeof data.category != 'undefined') {
                em[2].innerHTML = data.category[0];
              }
              if(typeof data.maxDaysToComplete != 'undefined') {
                em[3].innerHTML = data.maxDaysToComplete[0];
              }
              if (typeof data.files != 'undefined') {
                em[4].innerHTML = data.files[0];
              }
              if (typeof data.fileCount != 'undefined') {
                em[5].innerHTML = data.fileCount[0];
              }
              if (typeof data.images != 'undefined') {
                em[6].innerHTML = data.images[0];
              }
              if(typeof data.tags != 'undefined') {
                em[7].innerHTML = data.tags[0];
              }
              if(typeof data.description != 'undefined') {
                em[8].innerHTML = data.description[0];
              }
              if(typeof data.introToBuyer != 'undefined') {
                em[9].innerHTML = data.introToBuyer[0];
              }
            }
          }
        });
      }
  </script>

  {{-- Image show after selecting --}}
  <script>
  $(document).on('change', '#serviceImages', function(e) {
      var files = this.files;
      console.log(files);
      if (this.files.length) {
        for (let i = 0; i < this.files.length; i++) {
            var file = this.files[i];
            var reader = new FileReader();

            reader.onload = function(e) {
                var data = e.target.result;

                document.getElementsByClassName('serviceImages-cont')[i].setAttribute('src', data);
            };

            reader.readAsDataURL(file);
        }
      }

  });


  </script>

@endpush
