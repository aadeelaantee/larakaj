@extends("base")

@section("content")

<div class="text-end"><a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-primary">{{ __('Posts') }}</a> </div>

{!! form($form) !!}

@if ($row->story)
    <h3> {{ $row->story->name }} </h3> <hr>

    <p> {{ __('In this story') }}:</p>

    <ul>
        @foreach ($row->story->posts as $post)
            <li>
                <a href="{{ route('admin.posts.edit', ['post' => $post]) }}">🖉</a>
                {{ $post->title }}
                
                @if ($post->is($row))
                    (this post)
                @endif
                
            </li>
        @endforeach
    </ul>
@endif

@endsection