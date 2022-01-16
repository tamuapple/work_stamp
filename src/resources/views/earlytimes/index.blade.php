@extends('layouts.app')

@section ('title', '早出申請一覧')

@section('content')

<early-time-index :month="{{ json_encode($month) }}"
:pending_earlytimes="{{ json_encode($pending_earlytimes) }}"></early-time-index>

@endsection
