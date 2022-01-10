@if ($script->user_id === auth()->user()->id)
  <a href="{{ route('scripts.edit', $script->id) }}"
    class="btn btn-info btn-sm text-white mr-2" data-e2e="script-{{ $key }}-edit"
  >編集</a>
@endif