@extends('base')

@section('title', $title)

@section('content')

<form method="post">
@csrf

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
    <input class="form-check-input" type="checkbox" name="remember_me" value="true">
    <label class="form-check-label">{{ __('Remember me') }}</label>
</div>

<div class="mb-3">
    <input class="btn btn-primary" type="submit" value="{{ __('Login') }}">
</div>
</form>


<a href="{{ route('register') }}">{{ __('New user?') }}</a> |
<a href="{{ route('password.forget') }}">{{ __('Forget password?') }}</a>
@endsection