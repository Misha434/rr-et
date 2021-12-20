@extends('layout')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-12">
      <h1 class="my-2">あるあるを投稿しましょう!</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <form action="{{ route('scripts.store') }}" method="post">
        @csrf
        <div class="form-group">
          <label for="content">投稿画面</label>
          <textarea class="form-control" id="content" rows="3" name="content"></textarea>
          <div class="text-right my-2">
            <button type="submit" class="btn btn-primary">送信</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection