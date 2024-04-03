@extends('base')

@section('title', $title)

@section('content')

{!! form($form) !!}

{{ __('Currently a user?') }} <a href="{{ route('login') }}">{{ __('Please login.') }}</a>
@endsection