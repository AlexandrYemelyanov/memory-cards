@extends('layouts.app')

@section('content')
    @include('partials.title', ['title' => 'Импорт CSV'])
    <memory-card-import></memory-card-import>
@endsection
