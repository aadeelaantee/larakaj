@extends('base')

@section('title', $title)

@section('content')

<div class="text-center h4 mb-3"> {{ $title }} </div>

{!! form($form) !!}

@endsection