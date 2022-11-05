@extends('layouts.app', ['pageSlug' => 'notification'])
@section('title','Notification')
@section('content')

<div class="alert alert-default" role="alert">
    {{Request::Path()}}
  </div>
  @if (Session::has('message'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{Session::get('message')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="tim-icons icon-simple-remove"></i>
    </button>
  </div>
@endif
<div class="content">
    <div class="row">
       <div class="col-md-12">
          <div class="card ">
             <div class="card-header">
                <div class="row">
                   <div class="col-8">
                      <h4 class="card-title">Notification Messages</h4>
                   </div>

                </div>
             </div>
             <div class="card-body">

                  <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="Title">Title<sup class="red" >*</sup></label>
                        <input type="text" name="title" id="title"   class="form-control"  placeholder="Notification Title">

                    </div>

                    <div class="form-group col-md-12">
                      <label for="category">Message<sup class="red" >*</sup></label>
                      <textarea class="form-control" rows="2" value="" placeholder="{{__('Notification.Message')}}" name="message" id="message" required></textarea>

                  </div>

                  </div>
              </div>


             <div class="card-body">
                <div class="">
                   <table class="table tablesorter " id="">
                      <thead class=" text-primary">
                         <tr>
                            <th scope="col">Message</th>
                         </tr>
                      </thead>
                      <tbody>
                        @forelse($messages as $key => $message)
                         <tr id='{{$key}}' class="bgcolor">

                                <td><input type="radio" id="msg[<?php $loop->iteration ?>]" name="msg[<?php $loop->iteration ?>]" value="{{$loop->iteration}}" onclick="msg_val(this,'<?php echo $message->message; ?>',{{$key}})"></td>
                                <td>{{$message->message}}</td>





                         </tr>

                         @empty
                         No Message Found
                         @endforelse

                      </tbody>
                   </table>
                </div>
             </div>

          </div>

       </div>
    </div>
 </div>

 <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            &nbsp;
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        {{-- <button type="submit" id="notificationSubmitButton" class="btn bg-default" onclick="sendNotification()">{{__('Send')}}</button> --}}
        <button type="submit" id="notificationSubmitButton" class="btn bg-default" onclick="sendNotificationAll()">{{__('Send to Consumer')}}</button>
        {{-- <button type="submit" id="notificationSubmitButton" class="btn bg-default" onclick="sendNotificationUser()">{{__('admin_menu.Send to Users')}}</button>
        <button type="submit" id="notificationSubmitButton" class="btn bg-default" onclick="sendNotificationDriver()">{{__('admin_menu.Send to Drivers')}}</button>
        <button type="submit" id="notificationSubmitButton" class="btn bg-default" onclick="sendNotificationVendor()">{{__('admin_menu.Send to Vendors')}}</button> --}}
    </div>
    <!-- /.col-lg-12 -->
</div>
</div>


 @endsection
@push('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css" integrity="sha512-0V10q+b1Iumz67sVDL8LPFZEEavo6H/nBSyghr7mm9JEQkOAm91HNoZQRvQdjennBb/oEuW+8oZHVpIKq+d25g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js" integrity="sha512-zP5W8791v1A6FToy+viyoyUUyjCzx+4K8XZCKzW28AnCoepPNIXecxh9mvGuy3Rt78OzEsU+VCvcObwAMvBAww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
 <script>
 function msg_val(obj, msg, id) {

                    $('.bgcolor').removeAttr('style');
                    $('#' + id).attr('style', "background:lightgrey");
                    if ($(obj).is(":checked")) {
                        document.getElementById("message").value = msg;
                    }
                }

                function sendNotificationAll() {
                    var notification_subject = $('#title').val();
                    var notification_message = $('#message').val();



                    if (notification_subject == "") {
                        $.alert({
                            title: 'Alert!',
                            content: 'Please enter subject!',
                        });

                        return false;
                    }

                    if (notification_message == "") {
                        $.alert({
                            title: 'Alert!',
                            content: 'Please enter message!',
                        });
                        return false;
                    }



                    jQuery('#notificationSubmitButton').attr('disabled', true);

                    // jQuery.ajax({
                    //     url: "{{url('')}}/admin/sendNotificationAll",
                    //     method: 'post',
                    //     data: {
                    //         "_token": $('meta[name="csrf-token"]').attr('content'),
                    //         "title": notification_subject,
                    //         "message": notification_message,

                    //     },
                    //     success: function(result) {
                    //         if (result.status) {
                    //             $('#messageDiv').html("<span style='color:green'>" + result.message + "</span>");
                    //         } else {
                    //             $('#messageDiv').html("<span style='color:red'>" + result.message + "</span>");
                    //         }
                    //         //$('#messageDiv').html("<span></span>");
                    //         //    console.log(result);

                    //         jQuery('#notificationSubmitButton').attr('disabled', false);
                    //     }

                    // });

                }




 </script>
@endpush
