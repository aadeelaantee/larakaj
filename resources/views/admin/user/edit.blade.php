@extends("base")

@section("content")

    <div class="text-end"> 
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">{{ __('Users') }}</a>
    </div>

    {!! form($form) !!}

    <div class="mt-5">
        <a href="{{ route('admin.users.password', ['user' => $row]) }}">{{ __('Change user password') }}</a>
    </div>
@endsection