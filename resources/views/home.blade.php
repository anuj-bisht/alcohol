@extends('layouts.app', ['pageSlug' => 'dashboard'])

@section('content')

{{-- Start User Model --}}

<div class="modal fade" id="allconsumer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <table class="table  tablesorter ">
                <thead class=" text-primary">
                    <tr>
                       <th scope="col">Name</th>
                       <th scope="col">Mobile</th>
                       <th scope="col">Email</th>

                    </tr>
                 </thead>
                  <tbody id="consumerData">
                @foreach(allconsumer() as $consumer)

                    <tr>

                      <td>{{$consumer->name}}</td>
                      <td>{{$consumer->mobile}}</td>
                      <td>{{$consumer->email}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>




        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>




  {{-- end User model --}}






<div class="row  pb-2">
 <div class="col-lg-2">
    <label for="date">Start Date</label>

    <input type="date"  class="form-control"  placeholder="Start Date" id="start_date">

 </div>
 <div class="col-lg-2">
    <label for="date">End Date</label>

    <input type="date"  class="form-control"  placeholder="End Date" id="end_date">

 </div>
 <div class="col-lg-2" >
    <label for="date"  style="display: contents;">.</label>

    <button type="button" href="javasvript:void()" style="display: block;" class="btn btn-primary" onclick="findData()">Search</button>


 </div>
</div>


<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">

      <div class="card card-stats" style="background: black;
      color: #FAEA48;">
        <div class="card-header card-header-warning card-header-icon">
          <div class="card-icon">
            <i class="tim-icons icon-single-02" style="color:#FAEA48;"></i>
          </div>
          <p class="card-category" style="color:#FAEA48;">Consumer</p>
          <h3 class="card-title " style="color:#FAEA48;"><span class="counter usercount">{{Consumercount()}}</span>

          </h3>
        </div>
        <div class="card-footer">
            <div class="stats">
              <i class="tim-icons icon-single-02"></i> Total Consumers
              <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#allconsumer" style="margin-left:10px;">View All</a>

            </div>
            {{-- <div class="stats">
              </div> --}}
          </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats"  style="background: black;
        color: #FAEA48;">
          <div class="card-header card-header-warning card-header-icon">
            <div class="card-icon">
              <i class="tim-icons icon-tag" style="color:#FAEA48;"></i>
            </div>
            <p class="card-category" style="color:#FAEA48;">Categories</p>
            <h3 class="card-title " style="color:#FAEA48;"><span class="counter">{{Totalcategory()}}</span>

            </h3>
          </div>
          <div class="card-footer">
              <div class="stats">
                <i class="tim-icons icon-tag"></i> Total Categories
              </div>
            </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats" style="background: black;
        color: #FAEA48;">
          <div class="card-header card-header-warning card-header-icon">
            <div class="card-icon">
              <i class="tim-icons icon-bag-16" style="color:#FAEA48;"></i>
            </div>
            <p class="card-category" style="color:#FAEA48;">Products</p>
            <h3 class="card-title " style="color:#FAEA48;"><span class="counter">{{Totalproduct()}}</span>

            </h3>
          </div>
          <div class="card-footer">
              <div class="stats">
                <i class="tim-icons icon-bag-16"></i> Total Products
              </div>
            </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats" style="background: black;
        color: #FAEA48;">
          <div class="card-header card-header-warning card-header-icon">
            <div class="card-icon">
              <i class="tim-icons icon-coins" style="color:#FAEA48;"></i>
            </div>
            <p class="card-category" style="color:#FAEA48;">Sale</p>
            <h3 class="card-title " style="color:#FAEA48;"><span class="counter totalsale">{{Totalsale()}}</span>

            </h3>
          </div>
          <div class="card-footer">
              <div class="stats">
                <i class="tim-icons icon-coins"></i> Total Sale
              </div>
            </div>
        </div>
      </div>
</div>
    {{-- <div class="row">
        <div class="col-12">
            <div class="card card-chart">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-sm-6 text-left">
                            <h5 class="card-category">Total Shipments</h5>
                            <h2 class="card-title">Performance</h2>
                        </div>
                        <div class="col-sm-6">
                            <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                            <label class="btn btn-sm btn-primary btn-simple active" id="0">
                                <input type="radio" name="options" checked>
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Accounts</span>
                                <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-single-02"></i>
                                </span>
                            </label>
                            <label class="btn btn-sm btn-primary btn-simple" id="1">
                                <input type="radio" class="d-none d-sm-none" name="options">
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Purchases</span>
                                <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-gift-2"></i>
                                </span>
                            </label>
                            <label class="btn btn-sm btn-primary btn-simple" id="2">
                                <input type="radio" class="d-none" name="options">
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Sessions</span>
                                <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-tap-02"></i>
                                </span>
                            </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartBig1"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="row">
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Total Shipments</h5>
                    <h3 class="card-title"><i class="tim-icons icon-bell-55 text-primary"></i> 763,215</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartLinePurple"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Daily Sales</h5>
                    <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i> 3,500€</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="CountryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Completed Tasks</h5>
                    <h3 class="card-title"><i class="tim-icons icon-send text-success"></i> 12,100K</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartLineGreen"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="card card-tasks">
                <div class="card-header ">
                    <h6 class="title d-inline">Tasks(5)</h6>
                    <p class="card-category d-inline">today</p>
                    <div class="dropdown">
                        <button type="button" class="btn btn-link dropdown-toggle btn-icon" data-toggle="dropdown">
                            <i class="tim-icons icon-settings-gear-63"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#pablo">Action</a>
                            <a class="dropdown-item" href="#pablo">Another action</a>
                            <a class="dropdown-item" href="#pablo">Something else</a>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="table-full-width table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="">
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="title">Update the Documentation</p>
                                        <p class="text-muted">Dwuamish Head, Seattle, WA 8:47 AM</p>
                                    </td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                            <i class="tim-icons icon-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="" checked="">
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="title">GDPR Compliance</p>
                                        <p class="text-muted">The GDPR is a regulation that requires businesses to protect the personal data and privacy of Europe citizens for transactions that occur within EU member states.</p>
                                    </td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                            <i class="tim-icons icon-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="">
                                                    <span class="form-check-sign">
                                                        <span class="check"></span>
                                                    </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="title">Solve the issues</p>
                                        <p class="text-muted">Fifty percent of all respondents said they would be more likely to shop at a company </p>
                                    </td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                            <i class="tim-icons icon-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="">
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="title">Release v2.0.0</p>
                                        <p class="text-muted">Ra Ave SW, Seattle, WA 98116, SUA 11:19 AM</p>
                                    </td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                            <i class="tim-icons icon-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="">
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="title">Export the processed files</p>
                                        <p class="text-muted">The report also shows that consumers will not easily forgive a company once a breach exposing their personal data occurs. </p>
                                    </td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                            <i class="tim-icons icon-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="">
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="title">Arival at export process</p>
                                        <p class="text-muted">Capitol Hill, Seattle, WA 12:34 AM</p>
                                    </td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                            <i class="tim-icons icon-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-title">Simple Table</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter" id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Country
                                    </th>
                                    <th>
                                        City
                                    </th>
                                    <th class="text-center">
                                        Salary
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                      Dakota Rice
                                    </td>
                                    <td>
                                      Niger
                                    </td>
                                    <td>
                                      Oud-Turnhout
                                    </td>
                                    <td class="text-center">
                                      $36,738
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Minerva Hooper
                                    </td>
                                    <td>
                                        Curaçao
                                    </td>
                                    <td>
                                        Sinaai-Waas
                                    </td>
                                    <td class="text-center">
                                        $23,789
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Sage Rodriguez
                                    </td>
                                    <td>
                                        Netherlands
                                    </td>
                                    <td>
                                        Baileux
                                    </td>
                                    <td class="text-center">
                                        $56,142
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Philip Chaney
                                    </td>
                                    <td>
                                        Korea, South
                                    </td>
                                    <td>
                                        Overland Park
                                    </td>
                                    <td class="text-center">
                                        $38,735
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Doris Greene
                                    </td>
                                    <td>
                                        Malawi
                                    </td>
                                    <td>
                                        Feldkirchen in Kärnten
                                    </td>
                                    <td class="text-center">
                                        $63,542
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Mason Porter
                                    </td>
                                    <td>
                                        Chile
                                    </td>
                                    <td>
                                        Gloucester
                                    </td>
                                    <td class="text-center">
                                        $78,615
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Jon Porter
                                    </td>
                                    <td>
                                        Portugal
                                    </td>
                                    <td>
                                        Gloucester
                                    </td>
                                    <td class="text-center">
                                        $98,615
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@push('js')
    <script src="{{ asset('admin/js/plugins/chartjs.min.js')}}"></script>
    <script>
        $(document).ready(function() {
          demo.initDashboardPageCharts();
        });


        function findData(){
            start_date = $('#start_date').val();
            end_date = $('#end_date').val();

            if(start_date=='' || end_date == ''){
                alert('fill dates properly');
                return false;
            }
            $('#consumerData').empty();
//             var consumerData=`<tr>
// <td>Aman</td>
// <td>9898989898</td>
// <td>aman@gmail.com</td>
// </tr>`
// var consumer_data=document.getElementById('consumerData')
// consumer_data.insertAdjacentHTML('afterbegin', consumerData);

            $.ajax({
                        method:'GET',
                        data:{'start_date':start_date, 'end_date':end_date},
                        url:"{{URL::to('data/search')}}/",
                        success:function(response){
                        $('.usercount').text(response['usercount']);
                            if(response['userdata']==''){
                                                 var message=`<div style="padding-top:10px;" class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>OOPS, No Consumer Found</strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <i class="tim-icons icon-simple-remove"></i>
                                            </button>
                                            </div>`
                                var consumer_data= document.getElementById('consumerData');
                                consumer_data.insertAdjacentHTML('afterbegin', message);
                            }else{
                            for (const data of response['userdata']) {
                                var consumerData=`<tr>
                                                <td>${data['name']}</td>
                                                <td>${data['mobile']}</td>
                                                <td>${data['email']}</td>
                                               </tr>`
                               var consumer_data=document.getElementById('consumerData')
                                consumer_data.insertAdjacentHTML('afterbegin', consumerData);
                                            }
                                        }
                                $('.totalsale').text(response['totalsale'])
                        // $('.usercount').val(response['usercount']);
                            // if(response.length == 0){
                            //     var message=`<div style="padding-top:10px;" class="alert alert-warning alert-dismissible fade show" role="alert">
                            //                 <strong>OOPS, No Product Found</strong>
                            //                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            //                 <i class="tim-icons icon-simple-remove"></i>
                            //                 </button>
                            //                 </div>`
                            //     var thead= document.getElementById('producttable');
                            //     thead.insertAdjacentHTML('afterbegin', message);
                            // }
                //             for (const data of response) {
                //                 var products=`<tr id="category">
                //             <td>${data['name']}</td>
                //             <td>${data['category_name']}</td>
                //             <td>
                //                 Active
                //             </td>
                //             <td class="text-right">
                //                <div class="dropdown">
                //                   <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                //                   <i class="fas fa-ellipsis-v"></i>
                //                   </a>
                //                   <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                //                     <a class="dropdown-item" href="{{asset('Product/EditProduct')}}/${data['id']}">Edit</a>
                //                   </div>
                //                </div>
                //             </td>
                //          </tr>`;


                // var thead= document.getElementById('producttable');
                // thead.insertAdjacentHTML('afterbegin', products);




                            }
                // console.log(response);
                //         }
                    });



        }
    </script>
@endpush
