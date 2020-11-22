@extends('template.master')
@section('breadcumb')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Data Member {{ $member->name }}</h1>
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
      <div class="col-md-12">
        <div class="card">
            <div class="card-header">
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <p>Buku yang sedang dipinjam:</p>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <td>Judul</td>
                    <td>Tanggal Peminjaman</td>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($member->borrowLogs()->borrowed()->get() as $log)
                    <tr>
                    <td>{{ $log->book->title }}</td>
                    <td>{{ $log->created_at }}</td>
                    </tr>
                    @empty
                    <tr>
                    <td colspan="2">Tidak ada data</td>
                    </tr>
                    @endforelse
                    </tbody>
                    </table>
                    <p>Buku yang telah dikembalikan:</p>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                            <td>Judul</td>
                            <td>Tanggal Kembali</td>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($member->borrowLogs()->returned()->get() as $log)
                        <tr>
                        <td>{{ $log->book->title }}</td>
                        <td>{{ $log->updated_at }}</td>
                        </tr>
                        @empty
                        <tr>
                        <td colspan="2">Tidak ada data</td>
                        </tr>
                        @endforelse
                        </tbody>
                        </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

          <!--/.col (right) -->

      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
{{-- </div> --}}
@endsection
@section('script')
@endsection