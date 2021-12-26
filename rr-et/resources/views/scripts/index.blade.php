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
        <input type="text" class="form-control" placeholder="ネタを検索" aria-label="ネタを検索" name="keyword" value="{{ $keyword }}">
        <div class="input-group-append">
          <input class="btn btn-outline-secondary" type="submit" value="検索">
        </div>
      </div>
    </form>
    <!-- Search Form End -->
    
    @if($scripts->count())
    <p>
      {{ $scripts->count() }} 件
    </p>
    
    <!-- Script Start -->
    <div class="row">
      @foreach($scripts as $script) 
        <div class="col-12">
          <div class="card mt-2 px-3 pt-3">
            <p>{{ $script->content }}</p>
            <span class="border"></span>
            <div class="d-block">
              <div class="float-left">
                <div class="d-flex">
                  <p class="mt-2">{{ $script->user->name }}</p>
                  <p class="mt-2 mx-2 d-none d-sm-block" style="color:gray;">{{ $script->created_at }}</p>
                </div>
              </div>
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
                >
              </form>
              <!-- 削除ボタン End -->
              
              <!-- 編集ボタン Start -->
              <a href="{{ route('scripts.edit', $script->id) }}"
                 class="btn btn-info btn-sm text-white float-right mt-1 mb-3 mx-2"
              >
              編集
              </a>
              <!-- 編集ボタン End -->
              </div>
              @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <!-- Script End -->
    
    @else
      <p>見つかりませんでした。</p>
    @endif

  </div>
@endsection