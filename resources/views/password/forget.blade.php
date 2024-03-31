@extends('base')

@section('title', $title)

@section('content')

    <form method="post" action="">
        @csrf
        <div class="mb-3">
            <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ __('Email') }}">
            @error('email')
                <div class="form-text">
                    {{ $message }}
                </div>            
            @enderror
        </div>
        

        <div class="mb-3">
            <input type="submit" class="btn btn-primary" value="{{ __('Reset password')}}">
        </div>
    </form>
@endsection