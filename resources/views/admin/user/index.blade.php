@extends('layouts.app', ['pageSlug' => 'user'])
@section('title','Users')
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
                      <h4 class="card-title">Consumers List</h4>
                   </div>
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
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Document Verified</th>
                            <th scope="col"></th>
                         </tr>
                      </thead>
                      <tbody>
                        @forelse($users as $user)
                         <tr id="category{{$user->id}}">
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
                                     <a class="dropdown-item" href="{{route('consumer.view',['user'=>$user->id])}}">view</a>
                                     {{-- <a class="dropdown-item" href="javascript:void(0)" onclick="deleteCategory({{$category->id}})">Delete</a> --}}
                                  </div>
                               </div>
                            </td>
                         </tr>
                         @empty
                         No Users Found
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
