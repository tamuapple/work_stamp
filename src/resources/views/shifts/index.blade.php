@extends('layouts.app')

@section ('title', 'シフト申請一覧')

@section('content')

<shift-index :month="{{ json_encode($month) }}"
:pending_shifts="{{ json_encode($pending_shifts) }}"></shift-index>

@endsection
