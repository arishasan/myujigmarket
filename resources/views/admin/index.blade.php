@extends('admin.mainlayout')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <form action="?" method="POST">
            @csrf
          <div class="row float-sm-right">
            <div class="col-lg-4">
              <div class="form-group">
                <label for="bulan">Periode Bulan</label>
                <select name="bulan" id="bulan" class="form-control" required>
                  <option value="01" {{ ( (isset($bulan) && $bulan == '01' ) || (!isset($bulan) && date('m') == '01') ? 'selected' : '' ) }}>Januari</option>
                  <option value="02" {{ ( (isset($bulan) && $bulan == '02' ) || (!isset($bulan) && date('m') == '02') ? 'selected' : '' ) }}>Februari</option>
                  <option value="03" {{ ( (isset($bulan) && $bulan == '03' ) || (!isset($bulan) && date('m') == '03') ? 'selected' : '' ) }}>Maret</option>
                  <option value="04" {{ ( (isset($bulan) && $bulan == '04' ) || (!isset($bulan) && date('m') == '04') ? 'selected' : '' ) }}>April</option>
                  <option value="05" {{ ( (isset($bulan) && $bulan == '05' ) || (!isset($bulan) && date('m') == '05') ? 'selected' : '' ) }}>Mei</option>
                  <option value="06" {{ ( (isset($bulan) && $bulan == '06' ) || (!isset($bulan) && date('m') == '06') ? 'selected' : '' ) }}>Juni</option>
                  <option value="07" {{ ( (isset($bulan) && $bulan == '07' ) || (!isset($bulan) && date('m') == '07') ? 'selected' : '' ) }}>Juli</option>
                  <option value="08" {{ ( (isset($bulan) && $bulan == '08' ) || (!isset($bulan) && date('m') == '08') ? 'selected' : '' ) }}>Agustus</option>
                  <option value="09" {{ ( (isset($bulan) && $bulan == '09' ) || (!isset($bulan) && date('m') == '09') ? 'selected' : '' ) }}>September</option>
                  <option value="10" {{ ( (isset($bulan) && $bulan == '10' ) || (!isset($bulan) && date('m') == '10') ? 'selected' : '' ) }}>Oktober</option>
                  <option value="11" {{ ( (isset($bulan) && $bulan == '11' ) || (!isset($bulan) && date('m') == '11') ? 'selected' : '' ) }}>November</option>
                  <option value="12" {{ ( (isset($bulan) && $bulan == '12' ) || (!isset($bulan) && date('m') == '12') ? 'selected' : '' ) }}>Desember</option>
                </select>
              </div>
              </div>
              <div class="col-lg-4">
              <div class="form-group">
                <label for="tahun">Periode Tahun</label>
                <input type="number" class="form-control" id="tahun" name="tahun" placeholder="Required" value="{{ isset($tahun) ? $tahun : date('Y') }}" required>
              </div>
              </div>
              <div class="col-lg-4">
              <div class="form-group">
                <label for="username">Aksi</label>
                <button type="submit" class="btn btn-outline-primary form-control"><i class="fas fa-search"></i> Terapkan</button>
              </div>
              </div>
            </div>
          </form>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-receipt"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Jml. Pesanan Bulan {{ App\Models\HelperModel::getNamaBulan($bulan ?? date('m')) }}</span>
              <span class="info-box-number">
                <h4>{{ $transaksi_count ?? 0 }}</h4>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-box"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Produk Baru Bulan {{ App\Models\HelperModel::getNamaBulan($bulan ?? date('m')) }}</span>
              <span class="info-box-number">
                <h4>{{ $produkbaru_count ?? 0 }}</h4>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Jml. Pesanan Berhasil Bulan {{ App\Models\HelperModel::getNamaBulan($bulan ?? date('m')) }}</span>
              <span class="info-box-number">
                <h4>{{ $pesanan_sukses ?? 0 }}</h4>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-box-open"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Produk Stok < 10</span>
              <span class="info-box-number">
                <h4>{{ $produk_stok ?? 0 }}</h4>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
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
      </div>


      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Chart Jumlah Transaksi By Metode Bayar Pada Bulan <b>{{ App\Models\HelperModel::getNamaBulan($bulan ?? date('m')) }}</b></h5>

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
                    <canvas id="chartMetodeBayar" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
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
        <div class="col-md-6">
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
                    <a href="{{ url('pesanan/detail') }}/{{ md5($val->id) }}" class="product-title">{{ $val->kode_transaksi }}
                      <span class="badge badge-warning float-right">Rp. {{ number_format($val->total_transaksi) }}</span></a>
                    <span class="product-description">
                    {{ date('d M Y, H:i:s', strtotime($val->created_at)) }} // <b>{{ $val->status }}</b>
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