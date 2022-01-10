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
    
    <div class="row">
      <div class="col-12 offset-md-1 col-md-10 offset-md-1">
        @include('share.script_search_form')
      </div>
    </div>
    
    <div class="row">
      <div class="col-12 offset-md-1 col-md-10 offset-md-1">
        @if($scripts->count())
          <p data-e2e="script-search-count">{{ $scripts_count }} 件</p>
        @else
          <p data-e2e="script-search-not-found">見つかりませんでした。</p>
        @endif
      </div>
    </div>

    <!-- Script Start -->
      @if($scripts->count())
        <div class="row">
          <div class="col-12 offset-md-1 col-md-10 offset-md-1">
            <div class="infinite-scroll">
              @include('share.script_part')
              <div class="text-center mt-2">{{ $scripts->links() }}</div>    
            </div>
          </div>
        </div>
      @endif
    <!-- Script End -->

    @include('share.infinite_scroll_js')
  </div>
@endsection