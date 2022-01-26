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
      <h1 class="my-2">あるあるを編集しましょう!</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <form action="{{ route('scripts.update', ['script' => $script]) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        @include('share.script_form')
      </form>
    </div>
  </div>

  @include('share.script_img_validation')
</div>

@endsection