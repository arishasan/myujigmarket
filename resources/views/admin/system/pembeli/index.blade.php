@extends('admin.mainlayout')



@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              Data Users Pembeli
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">System</a></li>
              <li class="breadcrumb-item">Users</li>
              <li class="breadcrumb-item active">Pembeli</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        @include('admin.parts.feedback')
        
        <div>
          <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
              <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Data</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Tambah Data Baru</a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-four-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                  
                <table id="table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th width="5%"></th>
                      <th>Nama</th>
                      <th width="20%">Username</th>
                      <th width="20%">Email</th>
                      <th width="15%"><center>Aksi</center></th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($data_user as $val)
                        <tr>
                          <td><center><i class="fas fa-user"></i></center></td>
                          <td>{{ $val->name }}</td>
                          <td>{{ $val->username }}</td>
                          <td>{{ $val->email }}</td>
                          <td><center>
                            @if(Auth()->user()->id == $val->id)
                            @else
                            <a href="{{ url('sys/pembeli/edit/') }}/{{ md5($val->id) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-outline-danger btn-sm delete" data-id="{{ md5($val->id) }}" data-nama="{{ $val->name }}"><i class="fas fa-trash"></i></button>
                            @endif
                          </center></td>
                        </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                      <th width="5%"></th>
                      <th>Nama</th>
                      <th width="20%">Username</th>
                      <th width="20%">Email</th>
                      <th width="15%"><center>Aksi</center></th>
                    </tr>
                    </tfoot>
                  </table>

                </div>
                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                  
                  <form action="{{ route('simpan-pembeli') }}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="nama">Nama <sup class="text-danger">*</sup></label>
                          <input type="text" class="form-control" id="nama" name="nama" placeholder="Required" value="{{ old('nama') }}" required>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="username">Username <sup class="text-danger">*</sup></label>
                          <input type="text" class="form-control" id="username" name="username" placeholder="Required" value="{{ old('username') }}" required>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="password">Password <sup class="text-danger">*</sup></label>
                          <input type="password" class="form-control" id="password" name="password" placeholder="Required" required>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="password_confirmation">Confirm Password <sup class="text-danger">*</sup></label>
                          <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Required" required>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label for="email">Email <sup class="text-danger">*</sup></label>
                          <input type="email" class="form-control" id="email" name="email" placeholder="Required" value="{{ old('email') }}" required>
                        </div>
                      </div>
                    </div>
                    
                    <div class="float-right">
                      <button type="submit" class="btn btn-outline-primary"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection

@section('scriptplus')

<script>
  $(function () {
    // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    $("#table").DataTable({
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');

    $('#table').on('click', '.delete', function(){
      let id = $(this).attr('data-id');
      let nama = $(this).attr('data-nama');

      Swal.fire({
        title: 'Hapus user '+nama+'?',
        showCancelButton: true,
        icon: 'warning',
        confirmButtonText: 'Hapus',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {

          let link = "{{ url('sys/pembeli/delete') }}/"+id;
          $.get(link, function(res){
            location.reload();
          });

        } else if (result.isDenied) {
        }
      })

    });

  });
</script>

@endsection