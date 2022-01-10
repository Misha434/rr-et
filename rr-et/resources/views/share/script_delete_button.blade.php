@if (($script->user_id === auth()->user()->id) || auth()->user()->role === 1)
  <form action="{{ route('scripts.destroy', $script->id) }}"
    method="post"
    >
    @csrf
    @method('delete')
    <input type="submit" value="削除" 
    class="btn btn-danger btn-sm" 
    onclick='return confirm("削除しますか？");'
    data-e2e="script-{{ $key }}-delete"
    >
  </form>
@endif