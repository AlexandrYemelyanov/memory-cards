@extends('layouts.app')

@section('content')
    <memory-card-groups :groups='@json($groups)'></memory-card-groups>
@endsection
