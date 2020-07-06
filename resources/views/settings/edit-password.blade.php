@extends('template.master')
@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Password</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            {!! Form::model(auth()->user(), ['route' => ['update.pass']]) !!}
            {{-- {{ method_field('PUT') }} --}}
            <div class="card-body">
              <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="exampleInputEmail1">Password Lama</label>
                {!! Form::password('password', ['class' => 'form-control']) !!}
                {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                {{-- <input type="name" class="form-control" id="exampleInputName" placeholder="Enter name"> --}}
              </div>
              <div class="form-group {{ $errors->has('new_password') ? ' has-error' : '' }}">
                <label for="exampleInputEmail1">Password Baru</label>
                {!! Form::password('new_password', ['class' => 'form-control']) !!}
                {!! $errors->first('new_password', '<p class="help-block">:message</p>') !!}
                {{-- <input type="name" class="form-control" id="exampleInputName" placeholder="Enter name"> --}}
              </div>
              <div class="form-group {{ $errors->has('new_password_confirmation') ? ' has-error' : '' }}">
                <label for="exampleInputEmail1">Konfirmasi Password Baru</label>
                {!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}
                {!! $errors->first('new_password_confirmation', '<p class="help-block">:message</p>') !!}
                {{-- <input type="name" class="form-control" id="exampleInputName" placeholder="Enter name"> --}}
              </div>
            </div>
            <hr/>
            <div class="card-footer">
              {!! Form::submit('Simpan', ['class' => 'btn btn-success pull-right']) !!}
          </div>
            </div>
            {{-- <div class="form-group">
                {!! Form::label('content', 'Content') !!}
                {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => 10]) !!}
            </div> --}}
        {!! Form::close() !!}
          </div>
          <!-- /.card -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection