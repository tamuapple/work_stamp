@extends('layouts.app')

@section ('title', 'シフト申請')

@section('content')

<shift-create :date="{{ json_encode($date) }}" :active_shift="{{ json_encode($active_shift) }}"></shift-create>

@endsection
