@extends('layouts.app')

@section ('title', $title)

@section('content')
<user-edit :title="{{ json_encode($title) }}" :user="{{ $user }}">
  <template v-slot:update-form>
    <form action="{{ route('user.update', $user->id) }}" method="post" id="form" class="forms-sample"
      enctype="multipart/form-data">
      @csrf
      @method('put')
      <div class="form-group">
        <label for="image">プロフィール画像</label>
        @if($errors->has('image'))
        <p class="text-danger mb-0">{{ $errors->first('image') }}</p>
        @endif
        <input type="file" name="image" class="form-control-file" id="image" accept="image/*">
      </div>
      <div class="form-group">
        <label for="username">名前</label>
        @if($errors->has('username'))
        <p class="text-danger mb-0">{{ $errors->first('username') }}</p>
        @endif
        <input type="text" name="username" class="form-control" id="username" value="{{ old('username', $user->username) }}">
      </div>
      <div class="form-group">
        <label for="email">メールアドレス</label>
        @if($errors->has('email'))
        <p class="text-danger mb-0">{{ $errors->first('email') }}</p>
        @endif
        <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $user->email) }}">
      </div>
      <div class="form-group">
        <label for="password">パスワード</label>
        @if($errors->has('password'))
        <p class="text-danger mb-0">{{ $errors->first('password') }}</p>
        @endif
        <input type="password" name="password" class="form-control" id="password">
      </div>
      <div class="form-group">
        <label for="password-confirm">パスワード(再)</label>
        <input type="password" name="password_confirmation" class="form-control" id="password-confirm">
      </div>
      @if($user->id != Auth::id() || $user->role == 1)
      <div class="form-group">
        <div class="form-check form-check-primary">
          <label class="form-check-label">
            <input type="radio" class="form-check-input" name="role" id="user" value="10"
            @if(old('role', $user->role) == 10) checked @endif> 一般ユーザー <i class="input-helper"></i>
          </label>
        </div>
        <div class="form-check form-check-primary">
          <label class="form-check-label">
            <input type="radio" class="form-check-input" name="role" id="admin" value="1"
            @if(old('role', $user->role) == 1) checked @endif> 管理者 <i class="input-helper"></i>
          </label>
        </div>
      </div>
      @endif
    </form>
  </template>
  @if(Auth::user()->role == 10 && $user->id != Auth::id())
  <template v-slot:delete-form>
    <form action="{{ route('user.destroy', $user->id) }}" method="post">
      @csrf
      @method('delete')
      <button type="submit" class="btn btn-gradient-danger">Delete</button>
    </form>
  </template>
  @endif
</user-edit>
@endsection
