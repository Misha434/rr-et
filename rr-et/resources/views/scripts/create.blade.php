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
      <h1 class="my-2">あるあるを投稿しましょう!</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <form action="{{ route('scripts.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('share.script_form')
      </form>
    </div>
  </div>
  
</div>

@endsection