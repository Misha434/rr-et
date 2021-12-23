@extends('layout')

@section('content')
  <div class="container">
    <!-- Title Start -->
    <div class="row">
      <div class="col-12">
        <h1 class="text-center my-3">{{ $category->name }}</h1>
      </div>
    </div>
    <!-- Title End -->

    <!-- Category Start -->
    @if($scripts->count())
    
    <div class="row">
      @foreach($scripts as $script) 
        <div class="col-6">
          <div class="card mt-2 px-3 pt-3">
            <p class="text-center">{{ $script->content }}</p>
          </div>
        </div>
      @endforeach
    </div>

    @else
      <p>Comming soon</p>
    @endif
    <!-- Category End -->
  </div>
@endsection