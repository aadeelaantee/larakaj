@extends('base')

@section('title', $title)

@section('canonical_tag')
    <link rel="canonical" href="{{ config('app.url') . '/' . $langCode->name .'/login' }}" />
@endsection

@section('content')

{!! form($form) !!}


<a href="{{ route('register') }}">{{ __('New user?') }}</a> |
<a href="{{ route('password.forget') }}">{{ __('Forget password?') }}</a>
@endsection