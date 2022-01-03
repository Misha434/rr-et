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
    
    <div class="row">
      @foreach($categories as $key => $category) 
        <div class="col-6">
          <a href="{{ route('categories.show', $category->id) }}" class="text-dark">
            <div class="card mt-2 px-3 pt-3">
              <h4 class="text-center" data-e2e="category-{{ $key }}">{{ $category->name }}</h4>
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
                  class="btn btn-danger btn-sm" data-e2e="category-{{ $key }}-delete"
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
          </a>
          </div>
          @endcan
          </div>
        </div>
      @endforeach
    </div>

    @else
      <p>Comming soon</p>
    @endif
    <!-- Category End -->
  </div>
@endsection