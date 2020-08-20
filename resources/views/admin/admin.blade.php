@php($selected = 'settings')
@extends('layouts.app')
@section('head_title','Admin panel')
@section('icon', 'fas fa-sliders-h')

@section('title', 'Admin panel')

@section('other_assets')
<style>
.card{
  width:7rem;
}
</style>
@endsection

@section('title_menu')
	{{-- Nếu là admin thì hiển thị --}}
	<span class="title_menu_item"><a href="{{ url('assignments/add') }}"><i class="fa fa-plus color8"></i> Add</a></span>
@endsection

@section('content')
<div class="card-group">
  <div class="m-3">
    <div class="card" >
      <i class="text-center card-img-top fas fa-cogs fa-4x p-4"></i>
      <div class="card-body bg-light">
        <h5 class="card-title">SETTING</h5>
        <p  class="card-text">Chỉnh sửa và ...</p>
        <a href="{{ route('settings.index') }}" class="stretched-link"></a>
      </div>
    </div>
  </div>
    
  <div class="m-3">
    <div class="card" >
      <i class="text-center card-img-top fas fa-users fa-4x p-4"></i>
      <div class="card-body bg-light">
        <h5 class="card-title">USERS</h5>
        <p  class="card-text">Quản lý người dùng</p>
        <a href="{{ route('users.index') }}" class="stretched-link"></a>
      </div>
    </div>
  </div>

  {{-- <div class="m-3">
    <div class="card" >
      <i class="text-center card-img-top fas fa-school fa-4x p-4"></i>
      <div class="card-body bg-light">
        <h5 class="card-title">CLASSES</h5>
        <p  class="card-text">Quản lý lớp học</p>
        <a href="{{ route('lops.index') }}" class="stretched-link"></a>
      </div>
    </div>
  </div> --}}

  <div class="m-3">
    <div class="card" >
      <i class="text-center card-img-top fas fa-laptop-code fa-4x p-4"></i>
      <div class="card-body bg-light">
        <h5 class="card-title">LANGUAGES</h5>
        <p  class="card-text">Thiết lập ngôn ngữ lập trình</p>
        <a href="{{ route('languages.index') }}" class="stretched-link"></a>
      </div>
    </div>
  </div>

  <div class="m-3">
    <div class="card" >
      <i class="text-center card-img-top fas fa-clipboard-list fa-4x p-4"></i>
      <div class="card-body bg-light">
        <h5 class="card-title">PROBLEMS</h5>
        <p  class="card-text">Danh sách bài tập</p>
        <a href="{{ route('problems.index') }}" class="stretched-link"></a>
      </div>
    </div>
  </div>
  <div class="m-3">
    <div class="card" >
      <i class="text-center card-img-top fas fa-tags fa-4x p-4"></i>
      <div class="card-body bg-light">
        <h5 class="card-title">TAGS</h5>
        <p  class="card-text">Đánh đầu các dạng thuật toán</p>
        <a href="{{ route('tags.index') }}" class="stretched-link"></a>
      </div>
    </div>
  </div>

  <div class="m-3">
    <div class="card" >
      <i class="text-center card-img-top fas fa-edit fa-4x p-4"></i>
      <div class="card-body bg-light">
        <h5 class="card-title">EDIT BY HTML</h5>
        <p  class="card-text">Soạn văn bản trên web</p>
        <a href="{{ url('htmleditor') }}" class="stretched-link"></a>
      </div>
    </div>
  </div>

  <div class="m-3">
    <div class="card" >
      <i class="text-center card-img-top fas fa-redo fa-4x p-4"></i>
      <div class="card-body bg-light">
        <h5 class="card-title">Rejudge</h5>
        <p  class="card-text">Zậy đó</p>
        <a href="{{ url('rejudge') }}" class="stretched-link"></a>
      </div>
    </div>
  </div>

  <div class="m-3">
    <div class="card" >
      <i class="text-center card-img-top fas fa-play fa-4x p-4"></i>
      <div class="card-body bg-light">
        <h5 class="card-title">Submission Queue</h5>
        <p  class="card-text">Zậy đó</p>
        <a href="{{ route('queue.index') }}" class="stretched-link"></a>
      </div>
    </div>
  </div>

  <div class="m-3">
    <div class="card" >
      <i class="text-center card-img-top fas fa-user-secret fa-4x p-4"></i>
      <div class="card-body bg-light">
        <h5 class="card-title">Detect Similar Codes</h5>
        <p  class="card-text">Zậy đó</p>
        <a href="{{ route('moss.index' , Auth::user()->selected_assignment_id) }}" class="stretched-link"></a>
      </div>
    </div>
  </div>
</div>


@endsection