@extends('layouts.app', ['pageSlug' => 'category'])
@section('title','Category')
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
                      <h4 class="card-title">Category</h4>
                   </div>
                   <div class="col-4 text-right">
                      <a href="{{route('category.create')}}" class="btn btn-sm btn-primary">Add Category</a>
                   </div>
                </div>
             </div>
             <div class="card-body">
                <div class="">
                   <table class="table tablesorter " id="">
                      <thead class=" text-primary">
                         <tr>
                            <th scope="col">Category Name</th>
                            <th scope="col">Status</th>
                            <th scope="col"></th>
                         </tr>
                      </thead>
                      <tbody>
                        @forelse($categories as $category)
                         <tr id="category{{$category->id}}">
                            <td>{{$category->category_name}}</td>
                            <td>
                                Active
                            </td>
                            {{-- <td>25/02/2020 09:11</td> --}}
                            <td class="text-right">
                               <div class="dropdown">
                                  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-ellipsis-v"></i>
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                     <a class="dropdown-item" href="{{route('category.edit',['category'=>$category->id])}}">Edit</a>
                                     <a class="dropdown-item" href="javascript:void(0)" onclick="deleteCategory({{$category->id}})">Delete</a>
                                  </div>
                               </div>
                            </td>
                         </tr>
                         @empty
                         No Category
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

      function deleteCategory(id){
            swal({
        title: "Are you sure?",
        text: "Are You Want to Delete Category!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        method:'GET',

                        url:"{{URL::to('Category/deleteCategory')}}/"+id,
                        success:function(response){

                            $('#category'+id).remove();
                        }
                    });


                    swal("Category has been deleted!", {
                    icon: "success",
                    });
                } else {
                    swal("Safe!");
                }
                });
            }


 </script>
@endpush
