@extends('layout')

@section('content')
<div class="container">
  @if($errors->any())
    <div class="row">
      <div class="col-12">
        <div class="alert alert-danger mt-2">
          <ul>
            @foreach($errors->all() as $message)
              <li>{{ $message }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  @endif

  <div class="row">
    <div class="col-12">
      <h1 class="my-2 text-center">ユーザー編集</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ route('users.update', $user->id) }}">
          @method('PUT')
          @csrf

          <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('ユーザー名') }}</label>

            <div class="col-md-6">
              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus data-e2e="name-input">
              <!-- <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus data-e2e="name-input"> -->

              @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong data-e2e="name-validate-message">{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>

          <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Emailアドレス') }}</label>

            <div class="col-md-6">
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" data-e2e="email-input">
              <!-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" data-e2e="email-input"> -->

              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>

          <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('パスワード') }}</label>

            <div class="col-md-6">
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" data-e2e="password-input" value="{{ $user->password }}">
              <!-- <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" data-e2e="password-input"> -->

              @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong data-e2e="password-validate-message">{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>

          <!-- <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('パスワード再入力') }}</label>

            <div class="col-md-6">
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" data-e2e="password-confirm-input">
            </div>
          </div> -->

          <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
              <button id="register-submit" type="submit" class="btn btn-primary" data-e2e="submit">
                {{ __('登録') }}
              </button>
            </div>
          </div>
        </form>
      </div>
      </div>
    </div>
  </div>
  
</div>

@endsection