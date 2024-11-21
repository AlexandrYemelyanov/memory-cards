@extends('layouts.app')

@section('content')
    @include('partials.title', ['title' => 'Импорт CSV'])
    <memory-card-import :groups='@json($groups)' :curr-group="{{$curr_group_id}}"></memory-card-import>
@endsection
