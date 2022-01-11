<div class="comments mt-4">
  @foreach($script->comments as $commentOrder => $comment)
    <div class="comment">
      <div class="border-top">
        <!-- Warning Start -->
          @if(($script->content_updated_at !== null) && ($comment->created_at < $script->content_updated_at))
            <div class="alert alert-warning my-2" role="alert">
              ネタ内容が変更される前のコメントです。
            </div>
          @endif
        <!-- Warning End -->
        <!-- Content Start -->
          <p class="mt-3">{{$comment->content}}</p>
        <!-- Content End -->
          <div class="d-block">
            <div class="float-left">
              <div class="d-flex">
                <!-- User link Start -->
                  <a href="{{ route('users.show', $comment->user->id) }}">
                    <p>{{$comment->user->name}}</p>
                  </a>
                <!-- User link End -->
                <!-- Comment Time Start -->
                  <p class="mx-2 my-0 d-none d-sm-block" style="color:gray;">{{ $comment->created_at->format('Y/m/d h:m') }}</p>
                <!-- Comment Time End -->
              </div>
            </div>
            <div class="float-right">
              @include('share.comment_delete_button')
            </div>
          </div>
      </div>
    </div>
  @endforeach
</div>