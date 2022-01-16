@extends('layouts.app')

@section ('title', '打刻申請一覧')

@section('content')

<work-stamp-index :month="{{ json_encode($month) }}"
:pending_work_stamps="{{ json_encode($pending_work_stamps) }}"></work-stamp-index>

@endsection
