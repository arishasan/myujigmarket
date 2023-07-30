@extends('admin.mainlayout')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <div class="row">

        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Chart Jumlah Transaksi Pada Bulan <b>{{ App\Models\HelperModel::getNamaBulan($bulan ?? date('m')) }}</b></h5>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <p class="text-center">
                    <strong>Periode: {{ date('01 M, Y', strtotime( (isset($bulan) ? $tahun.'-'.$bulan : date('Y-m')) )) }} - {{ date('t M Y', strtotime( (isset($bulan) ? $tahun.'-'.$bulan : date('Y-m')) )) }}</strong>
                  </p>

                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <div class="chart">
                    <canvas id="barChart" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
                    </div>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- ./card-body -->
            
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">6 Transaksi Terakhir Bulan <b>{{ App\Models\HelperModel::getNamaBulan($bulan ?? date('m')) }}</b></h5>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                
                @foreach($transaksi_terakhir as $val)
                <li class="item">
                  <div class="product-img">
                    <img src="{{ asset('assets') }}/dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                  </div>
                  <div class="product-info">
                    <a href="{{ url('pesanan/detail') }}/{{ md5($val->id) }}" class="product-title">{{ $val->kode_transaksi }}</a>
                    <span class="product-description">
                    {{ date('d M Y, H:i:s', strtotime($val->created_at)) }} // <b>{{ $val->status }}</b> <br/>
                    <h3>Rp. {{ number_format($val->total_transaksi) }}</h3>
                    </span>
                  </div>
                </li>
                @endforeach

              </ul>
            </div>
            
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>

      </div>

     
    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection

@section('scriptplus')

<script src="{{ asset('assets') }}/plugins/chart.js/Chart.min.js"></script>

<script>
  
  function loadGraph(){

    let parse = JSON.parse('<?= $chart_jml_transaksi ?>');

    let label = [];
    let jml = [];
    $.each(parse, function(i, o){
        label.push(o.label);
        jml.push(o.jml);
    });

    var areaChartData = {
      labels  : label,
      datasets: [
        {
          label               : 'Jumlah Transaksi',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : jml
        }
      ]
    }

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    barChartData.datasets[0] = temp0;

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false,
      tooltips: {
          callbacks: {
              label: function(tooltipItem, data) {
                  var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];

                  lastHoveredDataIndex = tooltipItem.datasetIndex;
                    lastHoveredIndex = tooltipItem.index;

                  value = value.toString();
                  value = value.split(/(?=(?:...)*$)/);
                  value = value.join(',');
                  return value;
              }
          }
        }, 
        scales: {
            yAxes: [{
              ticks: {
                  beginAtZero:true,
                  userCallback: function(value, index, values) {
                    value = value.toString();
                    value = value.split(/(?=(?:...)*$)/);
                    value = value.join(',');
                    return value;
                  }
              }
            }],
            xAxes: [{
              ticks: {
              }
            }]
        },
        
        
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions,
      
    });

  }

  function loadGraphTwo(){

    let parse = JSON.parse('<?= $chart_metode_bayar ?>');

    let label = [];
    let jml = [];
    $.each(parse, function(i, o){
        label.push(o.label);
        jml.push(o.jml);
    });

    var areaChartData = {
      labels  : label,
      datasets: [
        {
          label               : 'Jumlah Transaksi',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : jml
        },
      ]
    }

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#chartMetodeBayar').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    barChartData.datasets[0] = temp0;

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false,
      tooltips: {
          callbacks: {
              label: function(tooltipItem, data) {
                  var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];

                  lastHoveredDataIndex = tooltipItem.datasetIndex;
                    lastHoveredIndex = tooltipItem.index;

                  value = value.toString();
                  value = value.split(/(?=(?:...)*$)/);
                  value = value.join(',');
                  return value;
              }
          }
        }, 
        scales: {
            yAxes: [{
              ticks: {
                  beginAtZero:true,
                  userCallback: function(value, index, values) {
                    value = value.toString();
                    value = value.split(/(?=(?:...)*$)/);
                    value = value.join(',');
                    return value;
                  }
              }
            }],
            xAxes: [{
              ticks: {
              }
            }]
        },
        
        
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions,
      
    });

  }
</script>

<script>
  $(function(){
    loadGraph();
    loadGraphTwo();
  });
</script>

@endsection