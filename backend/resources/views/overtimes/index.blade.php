@extends('layouts.app')

@section ('title', '残業申請一覧')

@section('content')

<over-time-index :month="{{ json_encode($month) }}"
:pending_overtimes="{{ json_encode($pending_overtimes) }}"></over-time-index>

@endsection
