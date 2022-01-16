@extends('layouts.app')

@section ('title', 'ユーザー')

@section('content')
<user-index :users="{{ json_encode($users) }}" :is_admin="{{ json_encode($is_admin) }}">
  <template>
    {{ $users->links() }}
  </template>
</user-index>
@endsection
