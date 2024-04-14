@extends('base')

@section('title', $title)

@section('canonical_tag')
    <link rel="canonical" href="{{ config('app.url') . '/' . $langCode->name .'/register' }}" />
@endsection

@section('content')

{!! form($form) !!}

{{ __('Currently a user?') }} <a href="{{ route('login') }}">{{ __('Please login.') }}</a>
@endsection