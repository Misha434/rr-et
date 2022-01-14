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
  <textarea class="form-control" id="content" rows="3" name="content" required>{{ old('content') }}</textarea>
  <div class="text-right my-2">
    <button type="submit" class="btn btn-success" name="draft" data-e2e="draft">下書き</button>
    <button type="submit" class="btn btn-primary" name="store" data-e2e="submit">送信</button>
  </div>
</div>