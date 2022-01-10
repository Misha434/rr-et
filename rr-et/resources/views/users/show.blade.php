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
        <!-- Script Start -->
        @if($postedScripts->count())
        <div class="row">
          @foreach($postedScripts as $key => $postedScript)
            <div class="col-12">
              <div class="card mt-2 px-3 pt-3">
                <p data-e2e="script-{{ $key }}">{{ $postedScript->content }}</p>
                <span class="border"></span>
                <div class="d-block">
                  <div class="float-left">
                    <div class="d-flex">
                      <p class="mt-2" data-e2e="postedScript-{{ $key }}-username">{{ $postedScript->user->name }}</p>
                      <p class="mt-2 mx-2 d-none d-sm-block" style="color:gray;">{{ $postedScript->created_at }}</p>
                    </div>
                  </div>
                  @can('general-user')
                    @if (($postedScript->user_id === auth()->user()->id) || $postedScript->user->role === 1)
                    <div class="float-right">
                      <!-- 削除ボタン Start -->
                      <form action="{{ route('scripts.destroy', $postedScript->id) }}"
                      method="post" class="float-right mt-1 mb-3"
                      >
                      @csrf
                      @method('delete')
                      <input type="submit" value="削除"
                            class="btn btn-danger btn-sm"
                            onclick='return confirm("削除しますか？");'
                            data-e2e="postedScript-{{ $key }}-delete"
                      >
                    </form>
                    <!-- 削除ボタン End -->

                    <!-- 編集ボタン Start -->
                    <a href="{{ route('scripts.edit', $postedScript->id) }}"
                      class="btn btn-info btn-sm text-white float-right mt-1 mb-3 mx-2" data-e2e="postedScript-{{ $key }}-edit"
                    >
                    編集
                    </a>
                    <!-- 編集ボタン End -->
                    </div>
                  @endif
                  @endcan
                </div>
            </div>
          </div>
          @endforeach
        </div>
        <!-- Script End -->

        @else
          <p data-e2e="script-search-not-found">見つかりませんでした。</p>
        @endif
      </div>

      <div class="tab-pane fade" id="like" role="tabpanel" aria-labelledby="like-tab">
        <!-- Script Start -->
        @if(count($likedScripts))
        <div class="row">
          @foreach($likedScripts[0] as $key => $likedScript)
            <div class="col-12">
              <div class="card mt-2 px-3 pt-3">
                <p data-e2e="script-{{ $key }}">{{ $likedScript->content }}</p>
                <span class="border"></span>
                <div class="d-block">
                  <div class="float-left">
                    <div class="d-flex">
                      <p class="mt-2" data-e2e="likedScript-{{ $key }}-username">{{ $likedScript->user->name }}</p>
                      <p class="mt-2 mx-2 d-none d-sm-block" style="color:gray;">{{ $likedScript->created_at }}</p>
                    </div>
                  </div>
                  @can('general-user')
                    @if (($likedScript->user_id === auth()->user()->id) || $likedScript->user->role === 1)
                    <div class="float-right">
                      <!-- 削除ボタン Start -->
                      <form action="{{ route('scripts.destroy', $likedScript->id) }}"
                      method="post" class="float-right mt-1 mb-3"
                      >
                      @csrf
                      @method('delete')
                      <input type="submit" value="削除"
                            class="btn btn-danger btn-sm"
                            onclick='return confirm("削除しますか？");'
                            data-e2e="likedScript-{{ $key }}-delete"
                      >
                    </form>
                    <!-- 削除ボタン End -->

                    <!-- 編集ボタン Start -->
                    <a href="{{ route('scripts.edit', $likedScript->id) }}"
                      class="btn btn-info btn-sm text-white float-right mt-1 mb-3 mx-2" data-e2e="likedScript-{{ $key }}-edit"
                    >
                    編集
                    </a>
                    <!-- 編集ボタン End -->
                    </div>
                  @endif
                  @endcan
                </div>
            </div>
          </div>
          @endforeach
        </div>
        <!-- Script End -->

        @else
          <p data-e2e="script-search-not-found">見つかりませんでした。</p>
        @endif
      </div>
    </div>

  </div>
@endsection