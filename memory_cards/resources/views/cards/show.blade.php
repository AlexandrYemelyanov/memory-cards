@extends('layouts.app')

@section('content')
    @isset($cards)
        <memory-card-view
            :cards='@json($cards)'
            :groups='@json($groups)'
            :current-group="'{{$current_group}}'"
            :current-lang='@json($current_lang)'
            :voice-key="'{{env('VOICE_KEY')}}'"
        ></memory-card-view>
    @endisset
@endsection
