@extends("base")

@section("content")
    {!! form($form) !!}

    <div class="mt-5">
        <a href="{{ route('admin.users.password', ['user' => $row]) }}">{{ __('Change user password') }}</a>
    </div>
@endsection