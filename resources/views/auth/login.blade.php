@extends('base')

@section('title', $title)

@section('content')

{!! form($form) !!}


<a href="{{ route('register') }}">{{ __('New user?') }}</a> |
<a href="{{ route('password.forget') }}">{{ __('Forget password?') }}</a>
@endsection