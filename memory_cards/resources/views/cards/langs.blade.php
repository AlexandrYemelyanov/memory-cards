@extends('layouts.app')

@section('content')
    <memory-card-langs :langs='@json($langs)'
                       :user-lang="'{{ $user_lang }}'"
                       :current-lang="'{{ $app_lang_loc }}'"
                       :access-langs='@json($access_langs)'
    ></memory-card-langs>
@endsection
