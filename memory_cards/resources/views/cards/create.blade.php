@extends('layouts.app')
@section('content')
        <h4 class="text-center text-light mb-4 fs-4">@lang('messages.card_create')</h4>
        <memory-card-create :card="{}" :groups='@json($groups)' :curr-group="{{$curr_group_id}}"></memory-card-create>
@endsection
