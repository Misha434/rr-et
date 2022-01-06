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
    
    <!-- Script Start -->
    @if($scripts->count())    
    <div class="row">
      @foreach($scripts as $key => $script) 
        <div class="col-12">
          <div class="card mt-2 px-3 pt-3">
            <p data-e2e="script-{{ $key }}">{{ $script->content }}</p>
            <span class="border"></span>
            <div class="d-block">
              <div class="float-left">
                <div class="d-flex">
                  <p class="mt-2" data-e2e="script-{{ $key }}-username">{{ $script->user->name }}</p>
                  <p class="mt-2 mx-2 d-none d-sm-block" style="color:gray;">{{ $script->created_at }}</p>
                </div>
              </div>
              @can('general-user')
                @if (($script->user_id === auth()->user()->id) || $script->user->role === 1)
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
@endsection