<button class="btn btn-outline-secondary btn-sm" type="button"
        data-toggle="collapse"
        data-target="#collapseComments-{{ $script->id }}"
        aria-expanded="false" aria-controls="collapseComments"
><i class="fas fa-comment"></i> {{ $script->comments->count() }}</button>