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
    
    <!-- Search Form Start --> 
    <form action="{{ route('scripts.index') }}" method="GET">
      @csrf
      <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="ネタを検索" aria-label="ネタを検索" name="keyword" value="{{ $keyword }}" data-e2e="script-search-form">
        <div class="input-group-append">
          <input class="btn btn-outline-secondary" type="submit" value="検索" data-e2e="script-search-submit">
        </div>
      </div>
    </form>
    <!-- Search Form End -->
    
    @if($scripts->count())
    <p data-e2e="script-search-count">{{ $scripts_count }} 件</p>
    
    <!-- Script Start -->
    <div class="row">
      <div class="infinite-scroll">
        @foreach($scripts as $key => $script) 
          <div class="col-12">
            <div class="card mt-2 px-3 pt-3">
              <p data-e2e="script-{{ $key }}">{{ $script->content }}</p>
              <div class="d-flex my-2">
              @if($script->isLiked($script->id, Auth::user()->id))
                <p class="like-mark">
                  <form action="{{ route('likes.destroy', ['id' => $script->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" id="destroyLike-disable" type="submit">いいね解除
                      <span class="likesCount">{{ $script->likes->count() }}</span>
                    </button>
                    <script>
                      $(function () {
                        $('button#destroyLike-disable').on('click',function () {
                          $(this).click(function () {
                            $(this).prop('disabled', true);
                          })
                        })
                      })
                    </script>
                  </form>
                </p>
              @else
                <p class="like-mark">
                  <form action="{{ route('likes.store', ['id' => $script->id]) }}" method="POST">
                    @csrf
                    <button id="like-disable" class="btn btn-outline-secondary  btn-sm" type="submit">いいね<span class="likesCount ml-2">{{ $script->likes->count() }}</span>
                    </button>
                    <script>
                      $(function () {
                        $('button#like-disable').on('click',function () {
                          $(this).click(function () {
                            $(this).prop('disabled', true);
                          })
                        })
                      })
                    </script>
                  </form>
                </p>
              @endif

              <button class="btn btn-light btn-sm" type="button" data-toggle="collapse" data-target="#collapseComments-{{ $key }}" aria-expanded="false" aria-controls="collapseComments">
                コメント {{ $script->comments->count() }}
              </button>
              </div>

              <div class="collapse" id="collapseComments-{{ $key }}">
                <form action="{{ route('comments.store', ['id' => $script->id]) }}" method="POST">
                  @csrf
                  <div class="form-group-{{ $key }}">
                    <label for="content">コメント</label>
                    <textarea class="form-control" id="content" rows="2" name="content"></textarea>
                    <div class="float-right">
                      <button type="submit" class="btn btn-primary mt-2" data-e2e="submit">送信</button>
                    </div>
                  </div>
                </form>

                <div class="comments mt-4">
                  @foreach($script->comments as $commentOrder => $comment)
                    <div class="border-top">
                      <p>{{$comment->content}}</p>
                      <div class="d-flex">
                        <p>{{$comment->user->name}}</p>

                          @if((Auth::user()->id === $comment->user->id )|| Auth::user()->role === 1)
                          <form action="{{ route('comments.destroy', ['id' => $comment->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" id="destroyComment-disable" type="submit" onclick='return confirm("削除しますか？");'
                          data-e2e="comment-{{ $commentOrder }}-delete">削除
                            </button>
                            <script>
                              $(function () {
                                $('button#destroyComment-disable').on('click',function () {
                                  $(this).click(function () {
                                    $(this).prop('disabled', true);
                                  })
                                })
                              })
                            </script>
                          </form>
                          @endif

                      </div>
                    </div>
                  @endforeach
                </div>
              </div>

              <span class="border"></span>
              <div class="d-block">
                <div class="float-left">
                  <div class="d-flex">
                    <a href="{{ route('users.show', $script->user->id) }}" class="mt-2" data-e2e="script-{{ $key }}-username">{{ $script->user->name }}</a>
                    <p class="mt-2 mx-2 d-none d-sm-block" style="color:gray;">{{ $script->created_at }}</p>
                  </div>
                </div>
                @can('general-user')
                  @if ($script->user_id === auth()->user()->id)
                  <div class="float-right">
                    <!-- 削除ボタン Start -->
                    <form action="{{ route('scripts.destroy', $script->id) }}"
                    method="post" class="float-right mt-1 mb-3"
                    >
                    @csrf
                    @method('delete')
                    <input type="submit" value="削除" 
                          class="btn btn-danger btn-sm" 
                          onclick='return confirm("削除しますか？");'
                          data-e2e="script-{{ $key }}-delete"
                    >
                  </form>
                  <!-- 削除ボタン End -->
                  
                  <!-- 編集ボタン Start -->
                  <a href="{{ route('scripts.edit', $script->id) }}"
                    class="btn btn-info btn-sm text-white float-right mt-1 mb-3 mx-2" data-e2e="script-{{ $key }}-edit"
                  >
                  編集
                  </a>
                  <!-- 編集ボタン End -->
                  </div>
                @endif
                @endcan
                  
                @can('admin')
                <div class="float-right">
                  <!-- 削除ボタン Start -->
                  <form action="{{ route('scripts.destroy', $script->id) }}"
                  method="post" class="float-right mt-1 mb-3"
                  data-e2e="script-{{ $key }}-delete"
                  >
                  @csrf
                  @method('delete')
                  <input type="submit" value="削除" 
                        class="btn btn-danger btn-sm" 
                        onclick='return confirm("削除しますか？");'
                  >
                </form>
                <!-- 削除ボタン End -->
                </div>
                @endcan
              </div>
          </div>
        </div>
        @endforeach
        <div class="text-center mt-2">{{ $scripts->links() }}</div>    
      </div>
    </div>
    <!-- Script End -->
    
    @else
      <p data-e2e="script-search-not-found">見つかりませんでした。</p>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
    <script type="text/javascript">
      $('ul.pagination').hide();
      $(function() {
        $('.infinite-scroll').jscroll({
          loadingHtml: '<div class="d-flex justify-content-center  text-secondary"><strong>Loading...</strong><div class="spinner-grow ml-auto" role="status"></div></div>',
          autoTrigger: true,
          padding: 0,
          nextSelector: '.pagination li.active + li a',
          contentSelector: 'div.infinite-scroll',
          callback: function() {
            $('ul.pagination').remove();
          }
        });
      });
    </script>
  </div>
@endsection