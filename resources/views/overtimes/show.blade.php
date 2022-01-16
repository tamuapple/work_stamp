@extends('layouts.app')

@section ('title', '残業詳細')

@section('content')

<over-time-show :user="{{ $user }}" :date="{{ json_encode($date) }}"
:active_overtime="{{ json_encode($active_overtime) }}"
:not_active_overtimes="{{ $not_active_overtimes }}"
:is_pending_overtime="{{ json_encode($is_pending_overtime) }}"
:start_at="{{ json_encode($start_at) }}"
:end_at="{{ json_encode($end_at) }}"
></over-time-show>

@endsection
