<form action="{{ route('comments.store', ['id' => $script->id]) }}" method="POST">
  @csrf
  <div class="form-group-{{ $script->id }}">
    <label for="content">コメント</label>
    <textarea class="form-control" id="content" rows="2" name="content" data-e2e="script-{{ $script->id }}-comment-form"  required></textarea>
    <button type="submit" class="btn btn-primary mt-2 btn-block" data-e2e="script-{{ $script->id }}-comment-submit">送信</button>
  </div>
</form>