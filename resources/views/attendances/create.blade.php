@extends('layouts.app')

@section ('title', '出勤簿登録')

@section('content')
<attendance-create :month="{{ json_encode($carbon->format('Y-m')) }}"
:days="{{ json_encode($days) }}"></attendance-create>
@endsection
