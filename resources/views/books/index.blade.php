@extends('template.master')
{{-- @section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.css">
@endsection --}}
@section('breadcumb')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Buku</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Buku</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
@endsection
@section('content')
<section class="content">
    <div class="row">
      <div class="col-md-8">
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
                  <th>Cover</th>
                  <th>Title</th>
                  <th>Author</th>
                  <th>Stock</th>
                  <th>Action</th>
                  {{-- <th>Engine version</th>
                  <th>CSS grade</th> --}}
                </tr>
                </thead>
                <tbody>

                    @php
                        $no =1;
                    @endphp
                @foreach ($books as $book)
                <tr>
                  <td>{{ $no++ }}</td>
                  @if (isset($book) && $book->cover)
                  <td><img src="{{ asset('img/'.$book->cover) }}" style="max-width: 50px"></td>
                  @else
                  <td>None</td>
                  @endif
                  <td>{{ $book->title }}</td>
                  <td>{{ $book->author->name }}</td>
                  <td>{{ $book->stock }}</td>
                  <td>
                    @role('admin')
                    <a href="{{ route('books.edit',$book->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm" id="delete" data-title="{{ $book->title }}" href="{{ route('books.destroy',$book->id) }}"><i class="fas fa-trash"></i></button>
                                <form action="" id="deleteForm" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <input type="submit" value="" style="display:none">
                                </form>
                    @endrole
                    @role('member')
                    <a class="btn btn-sm btn-primary" href="{{ route('books.borrow', $book->id) }}">Pinjam</a>
                    @endrole
                  </td>
                </tr>
                @endforeach
                
                </tbody>
                <tfoot>
                <tr>
                    <th>No</th>
                    <th>Cover</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Stock</th>
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
        @role('admin')
        <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tambah Buku</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::open(['url' => route('books.store'), 'files'=>'true']) !!}
                <div class="card-body">
                  <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                    <label for="exampleInputEmail1">Title</label>
                    {!! Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'title']) !!}
                    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                    {{-- <input type="name" class="form-control" id="exampleInputName" placeholder="Enter name"> --}}
                  </div>
                  <div class="form-group {{ $errors->has('author_id') ? ' has-error' : '' }}">
                    <label for="exampleInputEmail1">Author</label>
                    {!! Form::select('author_id', $authors, null, ['class' => 'authors form-control','placeholder' => 'Author']) !!}
                    {{-- {!! Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'title']) !!} --}}
                    {!! $errors->first('author_id', '<p class="help-block">:message</p>') !!}
                    {{-- <input type="name" class="form-control" id="exampleInputName" placeholder="Enter name"> --}}
                  </div>
                  <div class="form-group {{ $errors->has('amount') ? ' has-error' : '' }}">
                    <label for="exampleInputEmail1">Amount</label>
                    {!! Form::number('amount', '', ['class' => 'form-control', 'placeholder' => 'Amount']) !!}
                    {!! $errors->first('amount', '<p class="help-block">:message</p>') !!}
                    {{-- <input type="name" class="form-control" id="exampleInputName" placeholder="Enter name"> --}}
                  </div>
                  <div class="form-group {{ $errors->has('cover') ? ' has-error' : '' }}">
                    <label for="exampleInputEmail1">Cover</label>
                    {!! Form::file('cover',  ['class' => 'form-control']) !!}
                    {!! $errors->first('cover', '<p class="help-block">:message</p>') !!}
                    {{-- <input type="name" class="form-control" id="exampleInputName" placeholder="Enter name"> --}}
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
      @endrole
      <!-- /.row -->
    </section>
    <!-- /.content -->
{{-- </div> --}}
@endsection
@section('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/selectize.min.js"></script> --}}
<script>
  $('button#delete').on('click', function(){
      var href= $(this).attr('href');
      var title= $(this).data('title')

      swal({
              title: "Apakah Kamu Yakin Akan Menghapus Buku " +title+ "?",
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
</script>
<script>
$(document).ready(function() {
    $('.authors').select2();
});
</script>
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