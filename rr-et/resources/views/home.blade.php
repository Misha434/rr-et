@extends('layout')

@section('content')
<div class="jumbotron jumbotron-fluid py-3">
  <div class="container">
    <h1 id="lead-message" class="display-5 text-center">あるある、</h1>
    <h1 class="display-5 text-center">早く言いたい</h1>
    @guest
    <div class="row">
      <div class="col-12 text-center col-md-6 text-md-right mt-3">
        <a href="{{ route('login') }}" class="btn btn-outline-primary">ログイン</a>
      </div>
      <div class="col-12 text-center text-md-left col-md-6 mt-3">
        <a href="{{ route('register') }}" class="btn btn-outline-secondary">新規登録</a>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-12 text-center text-md-center">
        <a href="/login/guest" class="btn btn-outline-success">ゲストログイン</a>
      </div>
    </div>
    @endguest
  </div>
</div>
<div class="container">
    <div class="row justify-content-center mt-3">
      @foreach($scripts as $script)
        <div class="col-12 offset-md-1 col-md-10 offset-md-1 offset-lg-1 col-lg-5 offset-lg-1">
          <div class="card mb-2 p-3">
            <p>{{ $script->content }}</p>
          </div>
        </div>
      @endforeach
    <div class="row">
      <div class="col-12 col-md-12">
        <a href="{{ route('scripts.index') }}" class="text-dark text-center"><u>続きを見る</u></a>
      </div>
    </div>
  </div>
</div>
@endsection
