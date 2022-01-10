<form action="{{ route('scripts.index') }}" method="GET">
  @csrf
  <div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="ネタを検索" aria-label="ネタを検索" name="keyword" value="{{ $keyword }}" data-e2e="script-search-form">
    <div class="input-group-append">
      <input class="btn btn-outline-secondary" type="submit" value="検索" data-e2e="script-search-submit">
    </div>
  </div>
</form>