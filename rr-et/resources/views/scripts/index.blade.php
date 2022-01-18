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
      <div class="col-12 offset-md-1 col-md-10 offset-md-1">
        <div class="float-right">
          <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{ $sortCondition ?? '新規投稿順' }}
            </button>
            <form action="{{ route('scripts.index') }}" method="GET">
              @csrf
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                <button class="dropdown-item" type="submit" name="sort" value="新規投稿順">新規投稿順</button>
                <button class="dropdown-item" type="submit" name="sort" value="いいね数">いいね数</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Script Start -->
      @if($scripts->count())
        <div class="row">
          <div class="col-12 offset-md-1 col-md-10 offset-md-1">
            <div class="infinite-scroll">
              @include('share.script_part')
              <div class="text-center mt-2">{{ $scripts->appends(request()->query())->links() }}</div>    
            </div>
          </div>
        </div>
      @endif
    <!-- Script End -->

    @include('share.infinite_scroll_js')
  </div>
@endsection