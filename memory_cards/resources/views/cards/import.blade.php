@extends('layouts.app')

@section('content')
    <h4 class="text-center text-light mb-4 fs-4">@lang('messages.import_csv')</h4>
    <memory-card-import :groups='@json($groups)' :curr-group="{{$curr_group_id}}"></memory-card-import>
@endsection
