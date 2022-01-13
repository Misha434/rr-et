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
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('ユーザー名') }}<span class="badge badge-danger ml-2 pt-1">※必須</span></label>

            <div class="col-md-6">
              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $user->name }}" required autocomplete="name" autofocus data-e2e="name-input">
              <!-- <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus data-e2e="name-input"> -->

              @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong data-e2e="name-validate-message">{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>

          <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Emailアドレス') }}<span class="badge badge-danger ml-2 pt-1">※必須</span></label>

            <div class="col-md-6">
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $user->email }}" required autocomplete="email" data-e2e="email-input">
              <!-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" data-e2e="email-input"> -->

              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>

          <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('新パスワード') }}</label>

            <div class="col-md-6">
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="password" data-e2e="password-input">
              

              @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong data-e2e="password-validate-message">{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>

          <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('新パスワード再入力') }}</label>

            <div class="col-md-6">
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="password" data-e2e="password-confirm-input">
            </div>
          </div>

          <div class="form-group row">
            <label for="current_password" class="col-md-4 col-form-label text-md-right">{{ __('登録済パスワード 確認') }}<span class="badge badge-danger ml-2 pt-1">※必須</span></label>

            <div class="col-md-6">
              <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" autocomplete="current_password" data-e2e="current_password-input" required>

              @error('current_password')
                <span class="invalid-feedback" role="alert">
                  <strong data-e2e="password-validate-message">{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>

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

  <div class="row mt-2">
    <div class="col-12">
      <form action="{{ route('users.destroy', $user->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="submit" value="退会" class="btn btn-block btn-outline-danger" onclick='return confirm("削除後に復元できません。本当に削除しますか？");'>
      </form>
    </div>
  </div>
</div>

@endsection