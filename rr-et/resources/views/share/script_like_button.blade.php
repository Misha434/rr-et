@if($script->isLiked($script->id, Auth::user()->id))
  <form action="{{ route('likes.destroy', ['id' => $script->id]) }}" method="POST">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger btn-sm mr-3" id="destroyLike-disable" type="submit">いいね解除
      <span class="likesCount">{{ $script->likes->count() }}</span>
    </button>
    <script>
      $(function () {
        $('button#destroyLike-disable').on('click',function () {
          $(this).click(function () {
            $(this).prop('disabled', true);
          })
        })
      })
    </script>
  </form>
@else
  <form action="{{ route('likes.store', ['id' => $script->id]) }}" method="POST">
    @csrf
    <button id="like-disable" class="btn btn-outline-secondary btn-sm mr-3" type="submit">いいね<span class="likesCount ml-2">{{ $script->likes->count() }}</span>
    </button>
    <script>
      $(function () {
        $('button#like-disable').on('click',function () {
          $(this).click(function () {
            $(this).prop('disabled', true);
          })
        })
      })
    </script>
  </form>
@endif