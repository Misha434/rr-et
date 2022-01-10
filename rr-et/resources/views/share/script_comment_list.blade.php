<div class="comments mt-4">
  @foreach($script->comments as $commentOrder => $comment)
    <div class="border-top">
      <!-- Content Start -->
        <p class="mt-3">{{$comment->content}}</p>
      <!-- Content End -->
      <div class="d-flex">
        <!-- User link Start -->
          <a href="{{ route('users.show', $comment->user->id) }}">
            <p>{{$comment->user->name}}</p>
          </a>
        <!-- User link End -->
        @include('share.comment_delete_button')
      </div>
    </div>
  @endforeach
</div>