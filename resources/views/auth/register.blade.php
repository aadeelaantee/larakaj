@extends('base')

@section('title', $title)

@section('content')

<form method="post">
@csrf

<div class="mb-3">
    <input class="form-control" type="text" name="name" placeholder="{{ __('Name') }}" value="{{ old('name') }}">
    @error('name')
        <div class="form-text">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <input class="form-control" type="text" name="username" placeholder="{{ __('Username') }}" value="{{ old('username') }}">
    @error('username')
        <div class="form-text">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <input class="form-control" type="text" name="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}">
    @error('email')
        <div class="form-text">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <input class="form-control" type="password" name="password" placeholder="{{ __('Password') }}">
    @error('password')
        <div class="form-text">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <input class="form-control" type="password" name="password_confirmation" placeholder="{{ __('Confirm password') }}">
    @error('password_confirmation')
        <div class="form-text">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <input class="btn btn-primary" type="submit" value="{{ __('Register') }}">
</div>

</form>

{{ __('Currently a user?') }} <a href="{{ route('login') }}">{{ __('Please login') }}
@endsection