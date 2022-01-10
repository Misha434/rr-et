<button class="btn btn-light btn-sm" type="button"
        data-toggle="collapse"
        data-target="#collapseComments-{{ $key }}"
        aria-expanded="false" aria-controls="collapseComments"
>コメント {{ $script->comments->count() }}</button>