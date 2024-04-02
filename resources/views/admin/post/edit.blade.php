@extends("base")

@section("content")

@if ($row->locked)
    <div class="alert alert-danger">
        {{ __('Post is locked!') }}
    </div>
@endif

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