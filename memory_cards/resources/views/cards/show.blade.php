@extends('layouts.app')

@section('content')
    @isset($cards)
        <memory-card-view :cards='@json($cards)' :groups='@json($groups)'></memory-card-view>
    @endisset
@endsection
