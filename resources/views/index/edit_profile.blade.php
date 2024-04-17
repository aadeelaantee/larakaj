@extends('base')

@section('title', $title)

@section('content')

<div class="text-center h4 mb-3"> {{ $title }} </div>

{!! form($form) !!}

@if ($user->image)
<img src="{{ $user->avatar() }}" class="img-thumbnail">

<p class="mt-3"> <a href="{{ route('delete_profile_image', ['user' => $user]) }}">{{ __('Delete profile image') }}</a> </p>
@endif

@endsection