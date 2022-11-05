@extends('layouts.app', ['pageSlug' => 'category'])

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
      <form method="POST" action="{{route('category.update',['id'=>$category->id])}}">
        @csrf
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="category">Edit Category<sup class="red" >*</sup></label>
            <input type="text" name="category_name" value={{$category->category_name}}  @error('category_name') required @enderror class="form-control"  placeholder="Category Name">
            @error('category_name')
            {{$message}}
            @enderror
        </div>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>

 @endsection
