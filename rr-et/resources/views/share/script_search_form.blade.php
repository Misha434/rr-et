<form action="{{ route('scripts.index') }}" method="GET">
  @csrf
  <div class="input-group">
    <input type="text" class="form-control" placeholder="ネタを検索" aria-label="ネタを検索" name="keyword" value="{{ $keyword }}" data-e2e="script-search-form">
    <div class="input-group-append">
      <input class="btn btn-outline-secondary" type="submit" value="検索" data-e2e="script-search-submit">
    </div>
  </div>
  <button class="btn btn-block btn-outline-secondary" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">+ 詳細検索</button>
  <div class="collapse multi-collapse" id="multiCollapseExample2">
    <div class="card p-3">
      <div class="form-group">
        <label for="advanced_search_category" class="col-form-label">カテゴリー</label>
        <select type="text" class="form-control" name="advanced_search_category">
          <option disabled style='display:none;' selected>カテゴリーを選択(任意)</option>
          @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>

        <label for="advanced_search_date_start" class="col-form-label">投稿日時 開始</label>
        <input type="text" class="form-control" id="advanced_search_date_start" name="advanced_search_date_start" placeholder="ex: 2022-01-01 から">

        <label for="advanced_search_date_end" class="col-form-label">投稿日時 終了</label>
        <input type="text" class="form-control" id="advanced_search_date_end" name="advanced_search_date_end" placeholder="ex: 2022-01-02 まで">

        <input class="btn btn-outline-secondary btn-block mt-4" type="submit" value="検索" data-e2e="script-search-submit">
      </div>
    </div>
  </div>
</form>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">

<script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ja.js"></script>
<script>
  flatpickr(document.querySelector('#advanced_search_date_start'), {
    locale: 'ja',
    dateFormat: "Y-m-d",
    maxDate: new Date()
  });

  flatpickr(document.querySelector('#advanced_search_date_end'), {
    locale: 'ja',
    dateFormat: "Y-m-d",
    maxDate: new Date()
  });
</script>