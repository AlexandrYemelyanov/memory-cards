@extends('layouts.app')
@section('content')
        @include('partials.title', ['title' => 'Создать карту'])
        <memory-card-create :card="{}" :groups='@json($groups)'></memory-card-create>
@endsection
