@if((Auth::user()->id === $comment->user->id) || Auth::user()->role === 1)
  <form action="{{ route('comments.destroy', ['id' => $comment->id]) }}" method="POST">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger btn-sm"
            id="destroyComment-disable"
            type="submit"
            onclick='return confirm("削除しますか？");'
            data-e2e="script-{{ $script->id }}-comment-{{ $comment->id }}-delete"
    >削除</button>
    <script>
      $(function () {
        $('button#destroyComment-disable').on('click',function () {
          $(this).click(function () {
            $(this).prop('disabled', true);
          })
        })
      })
    </script>
  </form>
@endif