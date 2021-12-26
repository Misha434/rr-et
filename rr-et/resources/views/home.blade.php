@extends('layout')

@section('content')
<div class="jumbotron jumbotron-fluid py-3">
  <div class="container">
    <h1 class="display-5 text-center">あるある、</h1>
    <h1 class="display-5 text-center">早く言いたい</h1>
    @guest
    <div class="row">
      <div class="col-12 text-center col-md-6 text-md-right mt-3">
        <button class="btn btn-outline-primary">ログイン</button>
      </div>
      <div class="col-12 text-center text-md-left col-md-6 mt-3">
        <button class="btn btn-outline-secondary">新規登録</button>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-12 text-center text-md-center">
        <button class="btn btn-outline-success">ゲストログイン</button>
      </div>
    </div>
    @endguest
  </div>
</div>
<div class="container">
    <div class="row justify-content-center mt-3">
      @foreach($scripts as $script)
        <div class="col-12 offset-md-1 col-md-5 offset-md-1">
          <div class="card mb-2 p-3">
            <p>{{ $script->content }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
