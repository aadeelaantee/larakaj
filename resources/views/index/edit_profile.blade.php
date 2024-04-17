@extends('base')

@section('title', $title)

@section('content')

<div class="row">
    <div class="col-md-6 text-start h4 mb-3 text-muted"> {{ $title }} </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('profile', ['user' =>$user]) }}" class="btn btn-primary btn-sm">{{ __('Profile') }}</a>
    </div>
</div>

{!! form($form) !!}

@if ($user->image)
<img src="{{ $user->avatar() }}" class="img-thumbnail">

<p class="mt-3"> <a href="{{ route('delete_profile_image', ['user' => $user]) }}">{{ __('Delete profile image') }}</a> </p>
@endif

@endsection