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


@if (! $row->posts()->count())
    <div class="text-end">
        <form  method="post" action="{{ route('admin.stories.destroy', ['story' => $row]) }}">
            @csrf
            @method('delete')
            <input type="submit" value="{{ __('Delete this story') }}" class="btn btn-danger">
        </form>
    </div>
@endif

@endsection