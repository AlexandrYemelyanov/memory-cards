@extends('layouts.app')

@section('content')
    <memory-card-groups :groups='@json($groups)'
                        :langs='@json($langs)'
                        :current-lang="'{{ $app_lang_loc }}'"
                        :current-group="'{{ $current_group }}'"
    ></memory-card-groups>
@endsection
