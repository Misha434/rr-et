@extends('layout')

@section('content')
  <div class="container">
    <!-- Title Start -->
      <div class="row">
        <div class="col-12 offset-md-1 col-md-10 offset-md-1">
          <h1 class="text-center my-3">{{ $category->name }}</h1>
        </div>
      </div>
    <!-- Title End -->
    
    @if($scripts->count())
      <div class="row">
        <div class="col-12 offset-md-1 col-md-10 offset-md-1">
          <div class="infinite-scroll">
            @include('share.script_part')
            <div class="text-center mt-2">{{ $scripts->links() }}</div>
          </div>
        </div>
      </div>
    @else
      <p>Comming soon</p>
    @endif
  </div>
  @include('share.infinite_scroll_js')
@endsection