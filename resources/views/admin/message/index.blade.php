@extends('layouts.app', ['pageSlug' => 'message'])
@section('title','Messages')
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
                   <div class="col-4 text-right">
                      <a href="{{route('message.create')}}" class="btn btn-sm btn-primary">Add Message</a>
                   </div>
                </div>
             </div>
             <div class="card-body">
                <div class="">
                   <table class="table tablesorter " id="">
                      <thead class=" text-primary">
                         <tr>
                            <th scope="col">Message</th>
                            <th scope="col">Status</th>
                            <th scope="col"></th>
                         </tr>
                      </thead>
                      <tbody>
                        @forelse($messages as $message)
                         <tr id="message{{$message->id}}">
                            <td>{{$message->message}}</td>
                            <td>
                                Active
                            </td>
                            <td class="text-right">
                               <div class="dropdown">
                                  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-ellipsis-v"></i>
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                     <a class="dropdown-item" href="{{route('message.edit',['id'=>$message->id])}}">Edit</a>
                                     <a class="dropdown-item" href="javascript:void(0)" onclick="deleteMessage({{$message->id}})">Delete</a>
                                  </div>
                               </div>
                            </td>
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

 @endsection
@push('js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
 <script>

      function deleteMessage(id){
            swal({
        title: "Are you sure?",
        text: "Are You Want to Delete Message!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        method:'GET',

                        url:"{{URL::to('Message/deletemessage')}}/"+id,
                        success:function(response){

                            $('#message'+id).remove();
                        }
                    });


                    swal("Message has been deleted!", {
                    icon: "success",
                    });
                } else {
                    swal("Safe!");
                }
                });
            }


 </script>
@endpush
