@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')

  <div class="row">

    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
      <div class="card ">

                <img
                  src="{{ Storage::url($user->avatar) }}"
                  alt="{{ $user->name }}"
                  class="img-fluid"
                  style="width: 100%; max-width: 208px; height: auto; display: block; margin: 0 auto;"
                >
              <div class="card-body">
                <h5><strong>个人简介</strong></h5>
                <p>{{ $user->introduction }}</p>
                <hr>
                <h5><strong>注册于</strong></h5>

                <p>{{ $user->created_at->diffForHumans() }}</p>
              </div>

    </div>
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
      <div class="card ">
        <div class="card-body">
          <h1 class="mb-0" style="font-size:22px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
        </div>
      </div>
      <hr>

      {{-- 用户发布的内容 --}}
      <div class="card ">
        <div class="card-body">
          暂无数据 ~_~
        </div>
      </div>

    </div>
  </div>
@stop
