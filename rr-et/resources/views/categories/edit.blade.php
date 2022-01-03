@extends('layout')

@section('content')
<div class="container">
  @if($errors->any())
    <div class="row">
      <div class="col-12">
        <div class="alert alert-danger mt-2">
          <ul>
            @foreach($errors->all() as $message)
              <li>{{ $message }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  @endif

  <div class="row">
    <div class="col-12">
      <h1 class="my-2">カテゴリー編集</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <form action="{{ route('categories.update', ['category' => $category]) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group">
          <label for="name">カテゴリー名</label>
          <textarea class="form-control" id="name"
                    rows="3" name="name" data-e2e="category-input"
          >{{ old('name') ?? $category->name }}</textarea>
          <div class="text-right my-2">
            <button type="submit" class="btn btn-primary" data-e2e="submit">送信</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  
</div>

@endsection