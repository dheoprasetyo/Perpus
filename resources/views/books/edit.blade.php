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
              <h3 class="card-title">Edit Book</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            {!! Form::model($book, ['route' => ['books.update', $book->id], 'files'=>'true']) !!}
            {{ method_field('PUT') }}
            <div class="card-body">
              <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="exampleInputEmail1">Nama</label>
                {!! Form::text('title',null, ['class' => 'form-control', 'placeholder' => 'title']) !!}
                {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                {{-- <input type="name" class="form-control" id="exampleInputName" placeholder="Enter name"> --}}
              </div>
              <div class="form-group {{ $errors->has('author_id') ? ' has-error' : '' }}">
                <label for="exampleInputEmail1">Author</label>
                {!! Form::select('author_id', $authors, null, ['class' => 'form-control authors']) !!}
                {{-- {!! Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'title']) !!} --}}
                {!! $errors->first('author_id', '<p class="help-block">:message</p>') !!}
                {{-- <input type="name" class="form-control" id="exampleInputName" placeholder="Enter name"> --}}
              </div>
              <div class="form-group {{ $errors->has('amount') ? ' has-error' : '' }}">
                <label for="exampleInputEmail1">Amount</label>
                {!! Form::number('amount', null, ['class' => 'form-control', 'placeholder' => 'Amount']) !!}
                {!! $errors->first('amount', '<p class="help-block">:message</p>') !!}
                {{-- <input type="name" class="form-control" id="exampleInputName" placeholder="Enter name"> --}}
              </div>
              @if (isset($book))
              <p class="help-block">{{ $book->borrowed }} buku sedang dipinjam</p>
              @endif
              <div class="form-group {{ $errors->has('cover') ? ' has-error' : '' }}">
                <label for="exampleInputEmail1">Cover</label>
                {!! Form::file('cover',  ['class' => 'form-control']) !!}
                @if (isset($book) && $book->cover)
                <p>
                {!! Html::image(asset('img/'.$book->cover), null, ['class'=>'img-rounded img-responsive\
                ', 'style'=>'max-width: 100px']) !!}
                </p>
                @endif
                {!! $errors->first('cover', '<p class="help-block">:message</p>') !!}
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

@section('script')
<script>
    $(document).ready(function() {
    $('.authors').select2();
});
</script>
@endsection
