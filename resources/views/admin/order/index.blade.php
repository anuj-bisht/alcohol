@extends('layouts.app', ['pageSlug' => 'order_list'])
@section('title','Order List')
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
                      <h4 class="card-title">Order List</h4>
                   </div>

                </div>
             </div>
             <div class="card-body">
                <div class="">
                   <table class="table tablesorter" id="">
                      <thead class=" text-primary">
                         <tr>
                            <th scope="col">Sno.</th>
                            <th scope="col">Order No.</th>
                            <th scope="col">Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Order Status</th>
                            <th scope="col">Payment Status</th>
                            <th scope="col">Action</th>
                         </tr>
                      </thead>
                      <tbody>
                        @forelse($orders as $order)
                         <tr id="order{{$order->id}}">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$order->order_no}}</td>
                            <td>{{$order->name}}</td>
                            <td>{{$order->phone}}</td>
                            <td><i class="fa-solid fa-indian-rupee-sign"></i>{{ number_format($order->total) }}</td>
                            <td>{{$order->order_status}}</td>
                            <td>{{$order->payment_status}}</td>
                            <td><a  href="{{route('order.view',['id'=>$order->id])}}"><i class="fa-solid fa-eye"></i></a></td>
                         </tr>
                         @empty
                         No Order Found
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

    //   function deleteMessage(id){
        //     swal({
        // title: "Are you sure?",
        // text: "Are You Want to Delete Message!",
        // icon: "warning",
        // buttons: true,
        // dangerMode: true,
        //         })
        //         .then((willDelete) => {
        //         if (willDelete) {
        //             $.ajax({
        //                 method:'GET',

        //                 url:"{{URL::to('Message/deletemessage')}}/"+id,
        //                 success:function(response){

        //                     $('#message'+id).remove();
        //                 }
        //             });


        //             swal("Message has been deleted!", {
        //             icon: "success",
        //             });
        //         } else {
        //             swal("Safe!");
        //         }
        //         });
        //     }


 </script>
@endpush
