@extends('layouts.app', ['pageSlug' => 'message'])

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
    @php echo str_replace('/',' -> ',Request::Path());  @endphp

  </div>
<div class="card">
    <div class="card-body">
      <form method="POST" action="{{route('message.store')}}">
        @csrf
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="category">Add Message<sup class="red" >*</sup></label>
            <input type="text" name="message"  @error('message') required @enderror class="form-control"  placeholder="Notification Message">
            @error('message')
            {{$message}}
            @enderror
        </div>
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
      </form>
    </div>
  </div>

 @endsection
