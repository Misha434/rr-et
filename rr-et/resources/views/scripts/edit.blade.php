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
      <h1 class="my-2">あるあるを編集しましょう!</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <form action="{{ route('scripts.update', ['script' => $script]) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group">
          <label for="category_id">カテゴリー</label>
          <span class="badge badge-danger pt-1">※必須</span>
          <select type="text" class="form-control" name="category_id" required>
            <option disabled style='display:none;' @if (empty($script->category_id)) selected @endif>選択してください</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" @if (isset($script->category_id) && ($script->category_id === $category->id)) selected @endif>{{ $category->name }}</option>
            @endforeach
          </select>
          
          <label for="content">投稿ネタ</label>
          <span class="badge badge-danger pt-1">※必須</span>
          <textarea class="form-control" id="content" rows="3" name="content" required>{{ old('content') ?? $script->content }}</textarea>
          @include('share.script_counter')
          @include('share.script_counter_js')
          <div class="text-right my-2">
            <button type="submit" class="btn btn-success" name="draft" data-e2e="draft">下書き</button>
            <button type="submit" class="btn btn-primary" name="store" data-e2e="submit">送信</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  
</div>

@endsection