@extends('template.master')
@section('breadcumb')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Transaksi</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Transaksi</li>
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
                  <th>User</th>
                  <th>Book</th>
                  <th>Date</th>
                  <th>Action</th>
                  {{-- <th>Engine version</th>
                  <th>CSS grade</th> --}}
                </tr>
                </thead>
                <tbody>

                    @php
                        $no =1;
                    @endphp
                @foreach ($borrowLogs as $item)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $item->user->name }}</td>
                  <td>{{ $item->book->title }}</td>
                  <td>{{ $item->created_at }}</td>
                  <td>
                    <a href="{{ route('books.return',$item->book_id) }}" class="btn btn-warning btn-sm">Kembalikan</a>
                  </td>
                </tr>
                @endforeach
                
                </tbody>
                <tfoot>
                <tr>
                  <th>No</th>
                  <th>User</th>
                  <th>Book</th>
                  <th>Date</th>
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

        
      <!-- /.row -->
    </section>
    <!-- /.content -->
{{-- </div> --}}
@endsection
@section('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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