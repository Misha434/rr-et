@extends('layout')

@section('content')
  <div class="container">
    <!-- Title Start -->
      <div class="row">
        <div class="col-12">
          <h1 class="text-center my-3">下書き一覧</h1>
        </div>
      </div>
    <!-- Title End -->

    
    <!-- Script Start -->
      @if($scripts->count())
        <div class="row">
          @foreach($scripts as $script)
            <div class="col-12">
              <a href="{{ route('scripts.edit', $script->id) }}" class="text-dark">
                <div class="card mt-2 px-3 pt-3">
                  <p data-e2e="script-{{ $script->id }}" data-e2e="script-{{ $script->id }}">{{ $script->content }}</p>
                  <div class="d-block mb-1">
                    <div class="float-left">
                      <div class="d-flex">
                        <!-- Posted Time Start -->
                        <p class="mx-2 my-0 d-none d-sm-block"
                        style="color:gray;">{{ $script->created_at->format('Y/m/d h:m') }}</p>
                        <!-- Posted Time End -->
                      </div>
                    </div>

                    <div class="float-right">
                      <div class="d-flex">
                        <!-- Category Start -->
                        <p class="my-0">カテゴリー:</p>
                        <a href="{{ route('categories.show', $script->category->id) }}">{{ $script->category->name }}</a>
                        <!-- Category End -->
                      </div>
                    </div>
                  </div>

                  <span class="border"></span>
                  <div class="d-block">
                    <div class="float-right">
                      <div class="d-flex my-2">
                        @include('share.script_delete_button', ['script'=>$script])
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      </div>
      <!-- Script End -->

      @else
        <div class="col-12">
          <p data-e2e="script-search-not-found">下書きの投稿はありません。</p>
        </div>
      @endif
  </div>
@endsection