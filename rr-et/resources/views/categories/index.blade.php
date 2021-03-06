@extends('layout')

@section('content')
  <div class="container">
    <!-- Title Start -->
    <div class="row">
      <div class="col-12">
        <h1 class="text-center my-3">カテゴリー一覧</h1>
      </div>
    </div>
    <!-- Title End -->

    <!-- Category Start -->
    @if($categories->count())
    
    <div class="infinite-scroll">
      <div class="row">
        @foreach($categories as $category) 
          <div class="col-6">
            <a href="{{ route('categories.show', $category->id) }}" class="text-dark">
              <div class="card mt-2 px-3 pt-3">
                <h4 class="text-center" data-e2e="category-{{ $category->id }}">{{ $category->name }}</h4>
                @can('admin')
                  <div class="d-block">
                    <div class="float-right">
                      <!-- 削除ボタン Start -->
                      <form action="{{ route('categories.destroy', $category->id) }}"
                      method="post" class="float-right mt-1 mb-3"
                      >
                      @csrf
                      @method('delete')
                      <input type="submit" value="削除" 
                      class="btn btn-danger btn-sm" data-e2e="category-{{ $category->id }}-delete"
                      onclick='return confirm("削除しますか？");'
                      >
                      </form>
                      <!-- 削除ボタン End -->
                    
                      <!-- 編集ボタン Start -->
                      <a href="{{ route('categories.edit', $category->id) }}"
                      class="btn btn-info btn-sm text-white float-right mt-1 mb-3 mx-2"
                      >
                      編集
                      </a>
                      <!-- 編集ボタン End -->
                    </div>
                  </div>
                @endcan
              </div>
            </a>
          </div>
        @endforeach
        <div class="text-center mt-2">{{ $categories->links() }}</div>
      </div>
    </div>

      <div class="row">
        <div class="col-12">
          <a href="{{ route('proposals.create') }}">
            <p class="text-center">カテゴリの提案をしませんか？</p>
          </a>
        </div>
      </div>

    </div>

    @else
      <p>登録なし</p>
      <a href="{{ route('proposals.create') }}" data-e2e="proposal-link">
        <p>カテゴリの提案をしませんか？</p>
      </a>
    @endif
    <!-- Category End -->
  </div>
  @include('share.infinite_scroll_js')
@endsection