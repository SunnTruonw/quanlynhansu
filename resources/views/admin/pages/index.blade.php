@extends('admin.layouts.main')


@section('content')
<section class="content">

    <style>
        .nav.nav-pills.ranges li{
            margin:  0 15px;
        }

        .nav.nav-pills.ranges li a{
            font-weight: 700;
            font-size: 18px;
        }
    </style>
    <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Tổng số nhân viên</span>
              <span class="info-box-number">
                {{$totalUser}}
                <small>/người</small>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cog"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Tổng số phòng ban</span>
              <span class="info-box-number">{{$totalRoom}}/ phòng</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Đang cập nhật</span>
              <span class="info-box-number">...</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-thumbs-up"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Đang cập nhật</span>
              <span class="info-box-number">....</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-6">
          <div class="card card-outline card-primary">
             <div class="card-header">
                <h3 class="card-title">Thống nhân viên xin nghỉ trong 5 nă gần đây</h3>
             </div>
             <!-- /.card-header -->
             <div class="card-body table-responsive p-0" style="height: 100vh ;">
                   <ul class="list-news-home list-group">


                    <canvas id="myChart" width="400" height="400"></canvas>

                       {{-- @foreach ($postNews as $item)
                       <li class="list-group-item">
                           <a href="{{route('admin.post.edit',['id'=>$item->id])}}"> <i class="fas fa-caret-right"></i> {{ $item->name }}</a>
                       </li>
                       @endforeach --}}

                   </ul>
             </div>
             <!-- /.card-body -->
          </div>
       </div>
       <div class="col-md-6">
           <div class="card card-outline card-primary">
               <div class="card-header">
                   <h3 class="card-title">Thống kê nhân viên nghỉ theo phòng ban</h3>
               </div>
               <div class="card-body table-responsive p-0" style="height: 100vh ;">
                   <ul class="list-news-home list-group">
                    <ul class="nav nav-pills ranges">
                        <li class="active"><a href="#" data-range='7'>7 Days</a></li>
                        <li><a href="#" data-range='30'>30 Days</a></li>
                        <li><a href="#" data-range='60'>60 Days</a></li>
                        <li><a href="#" data-range='90'>90 Days</a></li>
                      </ul>

                        <div div id="stats-container" style="height: 250px;"></div>
                        <div id="chart" style="height: 250px;"></div>
                       {{-- @foreach ($productNews as $item)
                       <li class="list-group-item">
                           <a href="{{route('admin.product.edit',['id'=>$item->id])}}"> <i class="fas fa-caret-right"></i> {{ $item->name }}</a>
                       </li>
                       @endforeach --}}
                   </ul>
               </div>
               <!-- /.card-body -->
           </div>
       </div>
      </div>

    </div><!--/. container-fluid -->
  </section>
@endsection

@section('js')
{{-- <script>
    const ctx = document.getElementById('myChart').getContext('2d');
    var data = <?= json_encode($data); ?>;
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            datasets: [{
                label: 'Thống kê nhân viên nghỉ hẳn',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script> --}}

<script>
    Morris.Bar({
      element: 'chart',
      data: [
        { date: '04-02-2014', value: 3 },
        { date: '04-03-2014', value: 10 },
        { date: '04-04-2014', value: 5 },
        { date: '04-05-2014', value: 17 },
        { date: '04-06-2014', value: 6 }
      ],
      xkey: 'date',
      ykeys: ['value'],
      labels: ['Orders']
    });

</script>


<script>
    $(function() {

      // Create a function that will handle AJAX requests
      function requestData(days, chart){
        $.ajax({
          type: "GET",
          dataType: 'json',
          url: "/apiBieuDo", // This is the URL to the API
          data: { days: days }
        })
        .done(function( data ) {
          // When the response to the AJAX request comes back render the chart with new data
          chart.setData(data);
        })
        .fail(function() {
          // If there is no communication between the server, show an error
          alert( "error occured" );
        });
      }

      var chart = Morris.Bar({
        // ID of the element in which to draw the chart.
        element: 'stats-container',
        data: [0, 0], // Set initial data (ideally you would provide an array of default data)
        xkey: 'date', // Set the key for X-axis
        ykeys: ['value'], // Set the key for Y-axis
        labels: ['Orders'] // Set the label when bar is rolled over
      });

      // Request initial data for the past 7 days:
    //   requestData(7, chart);

      $('ul.ranges a').click(function(e){
        e.preventDefault();

        // Get the number of days from the data attribute
        var el = $(this);
        days = el.attr('data-range');

        // Request the data and render the chart using our handy function
        requestData(days, chart);
      })
    });
    </script>


@endsection
