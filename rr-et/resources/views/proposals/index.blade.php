@extends('layout')

@section('content')
  <div class="container">
    <!-- Title Start -->
    <div class="row">
      <div class="col-12">
        <h1 class="text-center my-3">カテゴリー提案一覧</h1>
      </div>
    </div>
    <!-- Title End -->

    <!-- Category Start -->
    @if($proposals->count())
    
    <div class="row">
      @foreach($proposals as $proposal) 
        <div class="col-12">
          <div class="card mt-2 px-3 pt-3">
            <h4 class="text-center" data-e2e="proposal-{{ $proposal->id }}">{{ $proposal->name }}</h4>
            <div class="d-block">
              <div class="float-right">
                <!-- 削除ボタン Start -->
                  <form action="{{ route('proposals.destroy', $proposal->id) }}"
                  method="post" class="float-right mt-1 mb-3"
                  >
                    @csrf
                    @method('delete')
                    <input type="submit" value="削除" 
                    class="btn btn-danger btn-sm" data-e2e="proposal-{{ $proposal->id }}-delete"
                    onclick='return confirm("削除しますか？");'
                    >
                  </form>
                <!-- 削除ボタン End -->

                <!-- 採用ボタン Start -->
                  <form action="{{ route('proposals.aprove', $proposal->id) }}"
                  method="post" class="float-right mt-1 mb-3"
                  >
                    @csrf
                    <input type="submit" value="採用" 
                    class="btn btn-primary btn-sm mr-2" data-e2e="proposal-{{ $proposal->id }}-aprove"
                    onclick='return confirm("採用しますか？");'
                    >
                  </form>
                <!-- 採用ボタン End -->
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    @else
      <p>登録なし</p>
    @endif
    <!-- Proposal End -->
  </div>
@endsection