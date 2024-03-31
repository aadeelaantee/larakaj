@extends('base')

@section('title', $title)

@section('content')

    <form method="post" action="">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        
        <div class="mb-3">
            <input type="email" name="email" placeholder="{{ __('Email') }}" class="form-control" value="{{ $email }}">
            @error('email')
                <div class="form-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="{{ __('Password') }}">
            @error('password')
                <div class="form-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Password confirmation') }}">
        </div>

        <div class="mb-3">
            <input type="submit" value="{{ __('Reset password') }}" class="btn btn-primary">
        </div>
    </form>
@endsection