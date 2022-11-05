@extends('layouts.app', ['pageSlug' => 'user'])
@section('title','Users')
@section('content')
<style>
    .item {
    position:relative;
    padding-top:20px;
    display:inline-block;
}
.notify-badge{
    position: absolute;
    right:-20px;
    top:10px;
    text-align: center;
    border-radius: 30px 30px 30px 30px;
    color:white;
    padding:5px 10px;
}

</style>

<div class="alert alert-default" role="alert">
View Detail
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
       <div class="col-md-6">
          <div class="card ">
             <div class="card-header">
                <div class="row">
                   <div class="col-8">
                      <h4 class="card-title font-weight-bold">Consumers Detail</h4>
                   </div>

                </div>
             </div>
             <div class="card-body">
                <div class="">
                   <table class="table tablesorter " id="">
                      <thead class=" text-primary">
                         <tr>
                            <th scope="col">Name</th>
                            <th class="text-center">{{$user->name}}</th>
                         </tr>
                         <tr>
                            <th scope="col">Mobile</th>
                            <th scope="col" class="text-center">{{$user->mobile}}</th>
                         </tr>
                         <tr>
                            <th scope="col">Email</th>
                            <th scope="col" class="text-center">{{$user->email}}</th>
                         </tr>
                         <tr>
                            <th scope="col">Age</th>
                            <th scope="col" class="text-center">{{$user->age}}</th>
                         </tr>
                      </thead>
                      <tbody>
                         {{-- <tr id="category{{$user->id}}">
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->mobile}}</td>
                            <td> <div class="form-check">
                                <label class="form-check-label">
                                    @if($user->doc_verified==1)

                                    <input class="{{$user->id}}" id="{{$user->id}}no" type="checkbox"  onclick="statusChange(this.id)"  checked >
                                    @else
                                    <input class="{{$user->id}}" id="{{$user->id}}yes" type="checkbox" onclick="statusChange(this.id)">
                                    @endif
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div></td>
                            <td class="text-right">
                               <div class="dropdown">
                                  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-ellipsis-v"></i>
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                     <a class="dropdown-item" href="{{route('consumer.view',['consumer'=>$user->id])}}">view</a>
                                  </div>
                               </div>
                            </td>
                         </tr> --}}

                      </tbody>
                   </table>
                </div>
             </div>

          </div>

       </div>


       <div class="col-md-5">

        <div class="card card-user">
            <div class="card-header">
                <div class="row">
                   <div class="col-12">
                      <h4 class="card-title font-weight-bold text-center">Document</h4>
                   </div>

                </div>
             </div>
            <div class="card-body">
                <div class="item">

                <span class="notify-badge" style="background: @if($user->doc_verified==1) rgba(111, 255, 0, 0.845); @else red; @endif">
                    @if($user->doc_verified==1) Verified @else Not Verified @endif</span>
                    <img class="card-img-top" src="{{ asset($user->doc)}}" alt="Card image cap">
                    <div class="item">


            </div>

        </div>
    </div>

    </div>
 </div>



 <div class="alert alert-default" role="alert">
    {{$user->name}} All Orders
  </div>

<div class="content">
    <div class="row">
       <div class="col-md-12">
          <div class="card ">
             <div class="card-header">
                <div class="row">
                   {{-- <div class="col-8">
                      <h4 class="card-title">{{$user->name}} All Orders</h4>
                   </div> --}}
                   {{-- <div class="col-4 text-right">
                      <a href="{{route('product.create')}}" class="btn btn-sm btn-primary">Add Product</a>
                   </div> --}}
                </div>
             </div>
             <div class="card-body">
                <div class="">
                   <table class="table tablesorter " id="">
                      <thead class=" text-primary">
                         <tr>
                            <th>Sno.</th>
                            <th scope="col">Order No.</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Order Status</th>
                            <th scope="col">Payment Status</th>
                            <th scope="col"></th>
                         </tr>
                      </thead>
                      <tbody>
                        @forelse($new_list as $order)
                         <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$order->order_no}}</td>
                            <td>{{$order->created_at->diffForHumans()}}</td>
                            <td>{{$order->total}}</td>
                            <td>{{$order->order_status->name}}</td>
                            <td>{{$order->payment_status->name}}</td>

                            <td> <div class="form-check">

                            </div></td>
                            <td class="text-right">

                           <a class="" href="{{route('order.view',['id'=>$order->id])}}">view</a>


                            </td>
                         </tr>
                         @empty
                         No Orders Found
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

    //   function deleteCategory(id){
    //         swal({
    //     title: "Are you sure?",
    //     text: "Are You Want to Delete Category!",
    //     icon: "warning",
    //     buttons: true,
    //     dangerMode: true,
    //             })
    //             .then((willDelete) => {
    //             if (willDelete) {
    //                 $.ajax({
    //                     method:'GET',

    //                     url:"{{URL::to('Category/deleteCategory')}}/"+id,
    //                     success:function(response){

    //                         $('#category'+id).remove();
    //                     }
    //                 });


    //                 swal("Category has been deleted!", {
    //                 icon: "success",
    //                 });
    //             } else {
    //                 swal("Safe!");
    //             }
    //             });
    //         }

    function statusChange(id){
    var checkbox= document.getElementById(id);
    if(checkbox.checked == true)
        {
            value = 'yes';
        }
        else
        {
            value = 'no';

        }

    var user_id= document.getElementById(id).className;  //user id
    $.ajax({
         type:'GET',
         dataType:'JSON',
         url:'{{URL::to("userstatus")}}/'+user_id+'/'+value,
         success:function(data){
             console.log(data);
         }
    });

    }


 </script>

@endpush
