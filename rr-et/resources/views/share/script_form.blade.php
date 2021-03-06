<div class="form-group">
  <label for="category_id">カテゴリー</label>
  <span class="badge badge-danger pt-1">※必須</span>
  <select type="text" class="form-control" name="category_id" required>
    <option disabled style='display:none;' @if (empty($script->category_id)) selected @endif>選択してください</option>
    @foreach($categories as $category)
    <option value="{{ $category->id }}" @if (isset($script->category_id) && ($script->category_id === $category->id)) selected @endif>{{ $category->name }}</option>
    @endforeach
  </select>
  
  <label for="content" class="mt-2">投稿ネタ</label>
  <span class="badge badge-danger pt-1">※必須</span>
  <textarea class="form-control" id="content" rows="3" name="content" required>{{ old('content', $script->content) }}</textarea>
  @include('share.script_counter')
  @include('share.script_counter_js')

  @if($script->script_img === null)
    <label for="script_img" class="mt-3">投稿画像</label><br>
    <input type="file" accept="image/jpeg,image/gif,image/png" name="script_img" id="script_img">
  @endif

  @unless($script->script_img === null)
    @if(!app()->isLocal())
      <img src="https://bucket-rr-et.s3-ap-northeast-1.amazonaws.com/{{ $script->script_img }}" class="img-fluid mt-1">
    @else
      <img src="{{ $script->script_img }}" class="img-fluid mt-1">
    @endif
  @endunless

  @unless($script->script_img === null)
    <div class="form-check mt-2">
      <input type="hidden" name="deleting" value="off" class="my-1" >
      <input type="checkbox" name="deleting" value="on" class="my-1">
      <label class="form-check-label" for="defaultCheck1">
        画像削除
      </label>
    </div>
  @endunless

  <div class="text-right my-2">
    <button type="submit" class="btn btn-success" name="draft" data-e2e="draft">下書き</button>
    <button type="submit" class="btn btn-primary" name="store" data-e2e="submit">送信</button>
  </div>
</div>