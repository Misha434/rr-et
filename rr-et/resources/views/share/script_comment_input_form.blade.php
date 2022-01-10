<form action="{{ route('comments.store', ['id' => $script->id]) }}" method="POST">
  @csrf
  <div class="form-group-{{ $key }}">
    <label for="content">コメント</label>
    <textarea class="form-control" id="content" rows="2" name="content"></textarea>
    <button type="submit" class="btn btn-primary mt-2 btn-block" data-e2e="submit">送信</button>
  </div>
</form>