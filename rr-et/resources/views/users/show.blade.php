@extends('layout')

@section('content')
  <div class="container">
    <!-- Title Start -->
    <div class="row">
      <div class="col-12">
        <h1 class="text-center my-3">{{ $user->name }}</h1>
      </div>
    </div>
    <!-- Title End -->

    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="script-tab" data-toggle="tab" href="#script" role="tab" aria-controls="script" aria-selected="true">投稿ネタ</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="like-tab" data-toggle="tab" href="#like" role="tab" aria-controls="like" aria-selected="false">いいね</a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="script" role="tabpanel" aria-labelledby="script-tab">
        @if($postedScripts->count())
          @include('share.script_part', ['scripts' => $postedScripts])
          <div class="text-center mt-2">{{ $postedScripts->links() }}</div>
        @else
        <p data-e2e="postedScript-not-found">まだ投稿していません。</p>
        @endif
      </div>
      
      
    </div>
    @include('share.infinite_scroll_js')
  </div>
@endsection