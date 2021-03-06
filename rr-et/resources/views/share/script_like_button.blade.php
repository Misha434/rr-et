@if($script->isLiked($script->id, Auth::user()->id))
  <form action="{{ route('likes.destroy', ['id' => $script->id]) }}" method="POST">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger btn-sm mr-3" id="destroyLike-disable" type="submit" data-e2e="script-{{ $script->id }}-like"><i class="fas fa-heart"></i>
      <span class="likesCount" data-e2e="script-{{ $script->id }}-like-count">{{ $script->likes_count }}</span>
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
    <button id="like-disable" class="btn btn-outline-danger btn-sm mr-3" type="submit" data-e2e="script-{{ $script->id }}-like"><i class="fas fa-heart"></i><span class="likesCount ml-2" data-e2e="script-{{ $script->id }}-like-count">{{ $script->likes->count() }}</span>
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