@extends('template.master')
@section('breadcumb')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Data Member</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">DataTables</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
@endsection
@section('content')
<section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
            <div class="card-header">
              {{-- <h3 class="card-title">DataTable with default features</h3> --}}
              {{-- <a class="btn btn-primary" href="{{ route('authors.create') }}">Tambah</a> --}}
              {{-- <button type="button" class="btn btn-sm btn-primary">Tambah</button> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Action</th>
                  {{-- <th>Engine version</th>
                  <th>CSS grade</th> --}}
                </tr>
                </thead>
                <tbody>

                    @php
                        $no =1;
                    @endphp
                @foreach ($members as $item)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $item->name }}
                  </td>
                  <td>{{ $item->email }}</td>
                  <td>
                    {{-- <a href="{{ route('authors.edit',$item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm" id="delete" data-title="{{ $item->name }}" href="{{ route('authors.destroy',$item->id) }}"><i class="fas fa-trash"></i></button>
                                <form action="" id="deleteForm" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <input type="submit" value="" style="display:none">
                                </form> --}}
                  </td>
                </tr>
                @endforeach
                
                </tbody>
                <tfoot>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tambah Member</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::open(['url' => route('members.store')]) !!}
                <div class="card-body">
                  <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="exampleInputEmail1">Nama</label>
                    {!! Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                    {{-- <input type="name" class="form-control" id="exampleInputName" placeholder="Enter name"> --}}
                  </div>
                  <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="exampleInputEmail1">Email</label>
                    {!! Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'email']) !!}
                    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                    {{-- <input type="email" class="form-control" id="exampleInputName" placeholder="Enter name"> --}}
                  </div>
                </div>
                <!-- /.card-body -->
  
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (right) -->

      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
{{-- </div> --}}
@endsection
@section('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
{{-- <script>
  $('button#delete').on('click', function(){
      var href= $(this).attr('href');
      var title= $(this).data('title')

      swal({
              title: "Apakah Kamu Yakin Akan Menghapus Author " +title+ "?",
              text: "Data yang terhapus tidak bisa dikembalikan",
              icon: "warning",
              buttons: true,
              dangerMode: true,
              })
              .then((willDelete) => {
              if (willDelete) {
                  document.getElementById('deleteForm').action = href;
                  document.getElementById('deleteForm').submit();
                  swal("Data Berhasil Dihapus", {
                  icon: "success",
                  });
              } 
          });

  });
</script> --}}
<script>
    $(function () {
      $("#example1").DataTable();
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
      });
    });
  </script>
@endsection