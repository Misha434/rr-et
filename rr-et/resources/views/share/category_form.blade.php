<div class="form-group">
  <label for="name">カテゴリー名</label>
  <textarea class="form-control" id="name"
            rows="3" name="name" data-e2e="category-input"
  >{{ old('name') ?? $category->name }}</textarea>
  <div class="text-right my-2">
    <button type="submit" class="btn btn-primary" data-e2e="submit">送信</button>
  </div>
</div>