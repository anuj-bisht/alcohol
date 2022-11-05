@extends('layouts.app', ['pageSlug' => 'view_order'])
@section('title','Order View')
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
<div class="alert alert-default text-center" role="alert" >
    Order Detail
  </div>
<div class="card">
    <div class="card-body">
        <div class="form-row">
        <div class="form-group col-md-3">
            <label for="category">Order No.</label>
            <input type="text" value="{{$order->order_no}}"   class="form-control"  readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="category">Subtotal Amount</label>
            <input type="text" value="{{$order->sub_total}}"   class="form-control"  readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="category">GST</label>
            <input type="text" value="{{$order->gst}}%"   class="form-control"  readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="category">Amount After GST</label>
            <input type="text" value="{{$order->amount_after_gst}}"   class="form-control"  readonly>
        </div>
        <div class="form-group col-md-3">
            <label for="category">Delivery Charges</label>
            <input type="text" value="{{$order->delivery_charge}}"   class="form-control"  readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="category">Total Amount</label>
            <input type="text" value="{{$order->total}}"   class="form-control"  readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="category">Order Status</label>
            <input type="text" value="{{$order->order_status}}"   class="form-control"  readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="category">Payment Status</label>
            <input type="text" value="{{$order->payment_status}}"   class="form-control"  readonly>
        </div>

        <div class="form-group col-md-3">
            <label for="category">Payment Mode</label>
            <input type="text" value="{{$order->payment_mode}}"   class="form-control"  readonly>
        </div>
        </div>
    </div>
  </div>



  <div class="alert alert-default text-center" role="alert" >
    Consumer Detail
  </div>
<div class="card">
    <div class="card-body">
        <div class="form-row">
        <div class="form-group col-md-4">
            <label for="category">Consumer Name</label>
            <input type="text" value="{{$order->name}}"   class="form-control"  readonly>
        </div>

        <div class="form-group col-md-4">
            <label for="category">Email</label>
            <input type="text" value="{{$order->email}}"   class="form-control"  readonly>
        </div>

        <div class="form-group col-md-4">
            <label for="category">Contact No.</label>
            <input type="text" value="{{$order->phone}}"   class="form-control"  readonly>
        </div>

        <div class="form-group col-md-8">
            <label for="category">Address</label>
            <textarea class="form-control"  rows="5" readonly>{{$order->address}}</textarea>
        </div>

        <div class="form-group col-md-4">
            <label for="category">Zip Code</label>
            <input type="text" value="{{$order->zip_code}}"   class="form-control"  readonly>
        </div>


        </div>
    </div>
  </div>

 @endsection


