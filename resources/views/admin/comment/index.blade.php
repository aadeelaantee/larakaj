@extends('base')

@section('title', $title)

@section('content')
   
    @forelse ($comments as $comment)
            <div @class([
                    "hover-overlay p-3 mt-3 mb-3 border",
                    "border-success" => $comment->active,
                    "border-danger" => !$comment->active
                ])>

                <p> {{ $comment->comment }} </p>
                
                <span class="badge bg-secondary">                
                {{ $comment->author->name ?? $comment->name }}</span> 
                
                <a class="badge bg-primary" href="{{ route('admin.posts.edit', ['post' => $comment->post]) }}">
                    {{ $comment->post->title }}
                </a>
                
                <span class="badge bg-warning"> {{ $comment->created_at }} </span> 
                
                <a class="badge bg-danger" href="{{ route('admin.comments.delete', ['comment' => $comment]) }}">
                    {{ __('Delete') }}
                </a>
            
                @if (! $comment->active)
                    <a class="badge border border-danger text-primary" 
                        href="{{ route('admin.comments.activate', ['comment' => $comment]) }}">
                            {{ __('Active') }}
                    </a>
                @else
                    <a class="badge border border-success text-primary" 
                        href="{{-- route('admin.comments.activate', ['comment' => $comment]) --}}">
                            {{ __('Deactive') }}
                    </a>                    
                @endif
            </div>
    @empty
        <h3> {{ __('No records found') }} </h3>
    @endforelse
   
@endsection