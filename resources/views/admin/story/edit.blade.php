@extends("base")

@section("content")

{!! form($form) !!}

@forelse ($row->posts as $post)
    @if ($loop->first)
        <h3 class="mt-5">{{ __('In this story') }}</h3> <hr>
    @endif

    <a href="{{ route('admin.posts.edit', ['post' => $post]) }}"> {{ $loop->iteration }} - {{ $post->title }} </a> <br>
@empty
    
@endforelse

@endsection