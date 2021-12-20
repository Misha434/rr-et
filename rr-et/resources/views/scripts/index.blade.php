@extends('layout')

@section('content')
  <div class="container">
    <!-- Title Start -->
    <div class="row">
      <div class="col-12">
        <h1 class="text-center my-3">ネタ一覧</h1>
      </div>
    </div>
    <!-- Title End -->
    
    <!-- Script Start -->
    <div class="row">
      @foreach($scripts as $script) 
        <div class="col-12">
          <div class="card mt-2 p-2">
            <p>{{ $script->content }}</p>
          </div>
        </div>
      @endforeach
    </div>
    <!-- Script End -->
  </div>
@endsection