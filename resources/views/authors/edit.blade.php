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
              <h3 class="card-title">Edit Author</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            {!! Form::model($author, ['route' => ['authors.update', $author->id]]) !!}
            {{ method_field('PUT') }}
            <div class="card-body">
              <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="exampleInputEmail1">Nama</label>
                {!! Form::text('name',null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                {{-- <input type="name" class="form-control" id="exampleInputName" placeholder="Enter name"> --}}
              </div>
            </div>
            <hr/>
            <div class="card-footer">
              {!! Form::submit('Update', ['class' => 'btn btn-success pull-right']) !!}
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