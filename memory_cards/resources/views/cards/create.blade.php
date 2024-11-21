@extends('layouts.app')
@section('content')
        @include('partials.title', ['title' => 'Создать карту'])
        <memory-card-create :card="{}" :groups='@json($groups)' :curr-group="{{$curr_group_id}}"></memory-card-create>
@endsection
