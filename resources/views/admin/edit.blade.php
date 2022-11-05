@extends('layouts.app', ['pageSlug' => 'product'])
@section('title','Product')
@section('content')
<style>
    .red{
        color:#c00000;
        font-size: small;
    }
    input:required:invalid {
  border-color: #c00000;
}

</style>
<div class="alert alert-default" role="alert">
    {{Request::Path()}}
  </div>
<div class="card">
    <div class="card-body">
      <form method="POST" action="{{route('product.update',['id'=>$product->id])}}" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="category">Add product<sup class="red" >*</sup></label>
            <input type="text" value="{{$product->name}}" name="name"  @error('name') required @enderror class="form-control"  placeholder="Product Name">
            @error('name')
            {{$message}}
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="category">Price<sup class="red" >*</sup></label>
            <input type="text" value="{{$product->price}}" name="price"  @error('price') required @enderror class="form-control"  placeholder="Price" onkeypress="return isNumberKey(event);">
            @error('price')
            {{$message}}
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="inputState">Product Category</label>
            <select id="category_id" class="form-control" name="category_id" required>
                @foreach ($categories as $category)
                @if($category->id == $product->category_id)
                <option selected value={{$category->id}}>
                @else
                <option  value={{$category->id}}>
                @endif
                    {{$category->category_name}}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="cover_image">Cover Image<sup class="red" >*</sup></label>
            <input type="file"  name="cover_image"  @error('cover_image') required @enderror class="form-control"  placeholder="Cover Image" >
            @error('cover_image')
            {{$message}}
            @enderror
          </div>

          <div class="form-group col-md-6">
            <label for="description">Description<sup class="red" >*</sup></label>
            <input type="text" name="description" value="{{$product->description}}"  @error('description') required @enderror class="form-control"  placeholder="description">
            @error('description')
            {{$message}}
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="type">Type<sup class="red" >*</sup></label>
            <input type="text" value="{{$product->type}}" name="type"  @error('type') required @enderror class="form-control"  placeholder="Type">
            @error('type')
            {{$message}}
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="type">Alcohol Percentage<sup class="red" >*</sup></label>
            <input type="text" name="alcohol_percentage" value="{{$product->alcohol_percentage}}"  @error('type') required @enderror class="form-control"  placeholder="Alcohol Percentage" onkeypress="return isNumberKey(event);">
            @error('alcohol_percentage')
            {{$message}}
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="type">Caleries<sup class="red" >*</sup></label>
            <input type="text" name="caleries" value="{{$product->caleries}}"  @error('caleries') required @enderror class="form-control"  placeholder="Caleries" onkeypress="return isNumberKey(event);">
            @error('caleries')
            {{$message}}
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="type">Litre<sup class="red" >*</sup></label>
            <input type="text" name="litre"  value="{{$product->litre}}"  @error('litre') required @enderror class="form-control"  placeholder="Litre" onkeypress="return isNumberKey(event);">
            @error('litre')
            {{$message}}
            @enderror
        </div>
        <div class="form-group col-md-3">
            <label for="cover_image">Cover Image<sup class="red" >*</sup></label>
            <input type="hidden" value="{{$product->cover_image}}" name="image">

            <img style="width:200px; height:150px;" src="{{asset($product->cover_image)}}">
          </div>
        </div>


        <div class="col-lg-12" id="product_image">
            <div class="card" id="product_image1">
                <div class="card-body" >
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="images">Product Images<sup class="red" >*</sup></label>

                            <input type="file"  name="images[]"  @error('images') required @enderror class="form-control"  placeholder="Product Image" >
                            @error('images')
                            {{$message}}
                            @enderror
                          </div>
                          <div class="form-group col-md-2" style="display:flex; flex-direction:column;">
                            <label for="add">Action<sup class="red" >*</sup></label>
                            <a  class="btn btn-primary btn-sm" onclick="add_more()">Add</a>
                          </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="onerow">
                    @foreach ($product->product_images as $productimages)
                    <span>
                    <i class="tim-icons icon-simple-remove" onclick="alert({{$productimages->id}})"></i>

                    <img style="width:200px; height:150px;" src="{{asset($productimages->images)}}">
                    </span>



                    @endforeach
                </div>
                </div>
            </div>


        <button type="submit" class="btn btn-primary">Add</button>
      </form>
    </div>
  </div>

 @endsection
 @push('js')
 <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

 <script>

 var loop_count=1;
 function add_more(){
 loop_count++;
     var html='<div class="card" id="product_image'+loop_count+'"><div class="card-body"><div class="form-row">';
         html+='<div class="form-group col-md-6" style="max-width:100%"><label for="images">Product Images<sup class="red" >*</sup></label><input type="file"  name="images[]"  required class="form-control"  placeholder="Product Image" ></div>'
         html+=' <div class="form-group col-md-2" style="display:flex; flex-direction:column;"><label for="remove">Action<sup class="red" >*</sup></label><a  class="btn btn-danger btn-sm" onclick=remove_more("'+loop_count+'")>Remove</a></div>'
         html+='</div></div></div>';
         $('#product_image').append(html);

 }

 function remove_more(id){
     $('#product_image'+id).remove();
 }
     </script>
 @endpush
