<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RR-ET</title>
  <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
  <script src="{{ asset('js/app.js') }}" ></script>
</head>
<body>
  <header>
    <div class="container-fluid g-0 bg-dark navbar-dark navbar-expand-lg">
      <div class="row g-0">
        <div class="col-3 col-lg-8 order-lg-1">
          <button class="navbar-toggler" type="button"
            data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="{{ __('Toggle navigation') }}"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
        <div class="navbar-nav">
          <div id="navbarSupportedContent" class="collapse navbar-collapse">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link {{ request()->route()->named('home*') ? ' active' : '' }}" href="{{ route('home') }}">ホーム</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->route()->named('categories*') ? ' active' : '' }}" href="{{ route('categories.index') }}">カテゴリー</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->route()->named('scripts*') ? ' active' : '' }}" href="{{ route('scripts.index') }}">ネタ一覧</a>
              </li>
            </ul>
          </div>
        </div>
        </div>
        <div class="col-6 col-lg-2 order-lg-0">
          <nav class="navbar-dark">
            <div class="container d-flex align-items-center">
              <a href="{{ url('/') }}" class="navbar-brand">
                RR-ET
              </a>
            </div>
          </nav>
        </div>
        <div class="col-3 col-lg-2 order-lg-2">
          @guest
            <div class="dropdown mr-3" data-e2e="user-dropdown">
              <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Not login
              </a>

              <div class="dropdown-menu dropdown-menu-right"
                  aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                @if (Route::has('register'))
                <a class="dropdown-item" href="{{ route('register') }}">{{ __('新規登録') }}</a>
                @endif
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/login/guest">{{ __('ゲストログイン') }}</a>
              </div>
            </div>
          @else
            <div class="dropdown" data-e2e="user-dropdown">
              <a class="btn btn-dark dropdown-toggle" href="#" role="button"
                id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false"
                data-e2e="auth-status"
              >{{ mb_strimwidth( Auth::user()->name, 0, 9, '...', 'UTF-8' ) }}</a>

              <div class="dropdown-menu dropdown-menu-right"
                  aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="{{ route('users.show', Auth::user()->id ) }}">{{ __('プロフィール') }}</a>
                <a class="dropdown-item" href="{{ route('scripts.create') }}">{{ __('ネタ新規投稿') }}</a>
                <div class="dropdown-divider"></div>
                @if(Auth::user()->email !== 'guest-user@example.com')
                  <a class="dropdown-item" href="{{ route('users.edit', Auth::user()->id) }}">{{ __('ユーザー設定') }}</a>
                @endif
                <a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                >{{ __('ログアウト') }}</a>

                <form id="logout-form" action="{{ route('logout') }}"
                      method="POST" style="display: none;"
                >@csrf</form>
              </div>
            </div>
          @endguest
        </div>
      </div>
    </div>
  </header>
  <main>
    @if (session('status'))
      <div class="alert alert-success" role="alert">
        {{ session('status') }}
      </div>
    @endif
    @yield('content')
  </main>
  <script></script>
  @yield('scripts')
</body>
</html>