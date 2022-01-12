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
        @if(count($postedScripts))
          @include('share.script_part', ['scripts' => $postedScripts])
          <div class="text-center mt-2">{{ $postedScripts->links() }}</div>
        @else
          <div class="col-12">
            <p data-e2e="script-search-not-found">まだ投稿していません。</p>
          </div>
        @endif
      </div>

      <div class="tab-pane fade" id="like" role="tabpanel" aria-labelledby="like-tab">
        <!-- Script Start -->
        @if(count($likedScripts[0]))
        <div class="row">
          @foreach($likedScripts[0] as $key => $likedScript)
            <div class="col-12">
              <div class="card mt-2 px-3 pt-3">
                <p data-e2e="script-{{ $key }}">{{ $likedScript->content }}</p>

                <div class="d-block mb-1">
                  <div class="float-left">
                    <div class="d-flex">
                      <!-- User Name Start -->
                      <a href="{{ route('users.show', $likedScript->user->id) }}"
                      data-e2e="script-{{ $key }}-username">{{ $likedScript->user->name }}</a>
                      <!-- User Name End -->

                      <!-- Posted Time Start -->
                      <p class="mx-2 my-0 d-none d-sm-block"
                      style="color:gray;">{{ $likedScript->created_at->format('Y/m/d h:m') }}</p>
                      <!-- Posted Time End -->
                    </div>
                  </div>

                  <div class="float-right">
                    <div class="d-flex">
                      <!-- Category Start -->
                      <p class="my-0">カテゴリー:</p>
                      <a href="{{ route('categories.show', $likedScript->category->id) }}">{{ $likedScript->category->name }}</a>
                      <!-- Category End -->
                    </div>
                  </div>
                </div>

                <span class="border"></span>
                <div class="d-block">
                  <div class="float-left">
                    <div class="d-flex my-2">
                      @include('share.script_like_button', ['script'=>$likedScript])
                      @include('share.script_comment_button', ['script'=>$likedScript])
                    </div>
                  </div>
                  <div class="float-right">
                    <div class="d-flex my-2">
                      @include('share.script_edit_button', ['script'=>$likedScript])
                      @include('share.script_delete_button', ['script'=>$likedScript])
                    </div>
                  </div>
                </div>

                <div class="collapse" id="collapseComments-{{ $key }}">
                  @include('share.script_comment_input_form', ['script'=>$likedScript])
                  @include('share.script_comment_list', ['script'=>$likedScript])
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <!-- Script End -->

        @else
          <div class="col-12">
            <p data-e2e="script-search-not-found">まだいいねをしていません。</p>
          </div>
        @endif
      </div>
    </div>
    @include('share.infinite_scroll_js')
  </div>
@endsection