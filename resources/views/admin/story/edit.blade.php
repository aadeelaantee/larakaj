@extends("base")

@section("content")

<div class="text-end"><a href="{{ route('admin.stories.index') }}" class="btn btn-sm btn-primary">{{ __('Stories') }}</a> </div>

{!! form($form) !!}

@forelse ($row->posts as $post)
    @if ($loop->first)
        <h3 class="mt-5">{{ __('In this story') }}</h3> <hr>
    @endif

    <a href="{{ route('admin.posts.edit', ['post' => $post]) }}"> {{ $loop->iteration }} - {{ $post->title }} </a> <br>
@empty
    
@endforelse

@endsection