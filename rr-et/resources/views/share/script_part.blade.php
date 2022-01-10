@foreach($scripts as $key => $script) 
  <div class="card mt-2 px-3 pt-3">

    <p data-e2e="script-{{ $key }}">{{ $script->content }}</p>

    <div class="d-block mb-1">
      <div class="float-left">
        <div class="d-flex">
          <!-- User Name Start -->
          <a href="{{ route('users.show', $script->user->id) }}"
          data-e2e="script-{{ $key }}-username">{{ $script->user->name }}</a>
          <!-- User Name End -->

          <!-- Posted Time Start -->
          <p class="mx-2 my-0 d-none d-sm-block"
          style="color:gray;">{{ $script->created_at->format('Y/m/d h:m') }}</p>
          <!-- Posted Time End -->
        </div>
      </div>

      <div class="float-right">
        <div class="d-flex">
          <!-- Category Start -->
          <p class="my-0">カテゴリー:</p>
          <a href="{{ route('categories.show', $script->category->id) }}">{{ $script->category->name }}</a>
          <!-- Category End -->
        </div>
      </div>
    </div>

    <span class="border"></span>
    <div class="d-block">
      <div class="float-left">
        <div class="d-flex my-2">
          @include('share.script_like_button')
          @include('share.script_comment_button')
        </div>
      </div>
      <div class="float-right">
        <div class="d-flex my-2">
          @include('share.script_edit_button')
          @include('share.script_delete_button')
        </div>
      </div>
    </div>

    <div class="collapse" id="collapseComments-{{ $key }}">
      @include('share.script_comment_input_form')
      @include('share.script_comment_list')
    </div>
  </div>

@endforeach