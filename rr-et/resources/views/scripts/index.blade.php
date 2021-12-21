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
    
    <!-- Script Start -->
    <div class="row">
      @foreach($scripts as $script) 
        <div class="col-12">
          <div class="card mt-2 px-3 pt-3">
            <p>{{ $script->content }}</p>
            <span class="border"></span>
            <div class="float-right">
              <!-- 削除ボタン Start -->
              <form action="{{ route('scripts.destroy', $script->id) }}"
              method="post" class="float-right mt-1 mb-3"
              >
              @csrf
              @method('delete')
              <input type="submit" value="削除" class="btn btn-danger btn-sm" 
              onclick='return confirm("削除しますか？");'
              >
            </form>
            <!-- 削除ボタン End -->
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <!-- Script End -->
  </div>
@endsection