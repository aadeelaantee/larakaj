@extends('base')

@section('title', $title)

@section('content')

    <h3> Please verify your email address </h3>


    <form method="post" action="{{ route('verification.resend') }}">
        @csrf

        <input type="submit" class="btn btn-primary" value="{{ __('Resend verification email') }}">
    </form>
@endsection