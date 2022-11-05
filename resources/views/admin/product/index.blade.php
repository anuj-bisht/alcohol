@extends('layouts.app', ['pageSlug' => 'product'])
@section('title','Products')
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




<nav class="navbar navbar-expand-lg bg-primary">
    <div class="container">


      <div class="collapse navbar-collapse" id="navbarTogglerDemo03">

            <div class="form-group no-border">
              <input type="text" class="form-control"  placeholder="Search" id="searchproduct">
            </div>
            <button  class="btn btn-link btn-icon btn-round" onclick="searchProduct()">
                <i class="tim-icons icon-zoom-split"></i>
            </button>
      </div>
    </div>
  </nav>






<div class="content">
    <div class="row">
       <div class="col-md-12">
          <div class="card ">
             <div class="card-header">
                <div class="row">
                   <div class="col-8">
                      <h4 class="card-title">Product</h4>
                   </div>
                   <div class="col-4 text-right">
                      <a href="{{route('product.create')}}" class="btn btn-sm btn-primary">Add Product</a>
                   </div>
                </div>
             </div>
             <div class="card-body">
                <div class="">
                   <table class="table tablesorter " id="">
                      <thead class=" text-primary">
                         <tr>
                            <th scope="col">Product Name</th>
                            <th scope="col">category Name</th>
                            <th scope="col">Status</th>
                            <th scope="col"></th>
                         </tr>
                      </thead>
                      <tbody id="producttable">
                        @forelse($products as $product)
                         <tr id="category{{$product->id}}">
                            <td>{{$product->name}}</td>
                            <td>{{$product->category->category_name}}</td>
                            <td>
                                Active
                            </td>
                            <td class="text-right">
                               <div class="dropdown">
                                  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-ellipsis-v"></i>
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                     <a class="dropdown-item" href="{{route('product.edit',['product'=>$product->id])}}">Edit</a>
                                     {{-- <a class="dropdown-item" href="javascript:void(0)" onclick="deleteCategory({{$category->id}})">Delete</a> --}}
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



    function searchProduct(){
        let value=$('#searchproduct').val();
        let actualvalue=value.trim();
        if(actualvalue.length > 0){
            $('#producttable').empty();
            $.ajax({
                        method:'GET',

                        url:"{{URL::to('Product/search')}}/"+actualvalue,
                        success:function(response){
                            if(response.length == 0){
                                var message=`<div style="padding-top:10px;" class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>OOPS, No Product Found</strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <i class="tim-icons icon-simple-remove"></i>
                                            </button>
                                            </div>`
                                var thead= document.getElementById('producttable');
                                thead.insertAdjacentHTML('afterbegin', message);
                            }
                            for (const data of response) {
                                var products=`<tr id="category">
                            <td>${data['name']}</td>
                            <td>${data['category_name']}</td>
                            <td>
                                Active
                            </td>
                            <td class="text-right">
                               <div class="dropdown">
                                  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-ellipsis-v"></i>
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item" href="{{asset('Product/EditProduct')}}/${data['id']}">Edit</a>
                                  </div>
                               </div>
                            </td>
                         </tr>`;


                var thead= document.getElementById('producttable');
                thead.insertAdjacentHTML('afterbegin', products);




                            }
                        }
                    });
        }else{
            alert('please enter value');
        }
    }


 </script>
@endpush
