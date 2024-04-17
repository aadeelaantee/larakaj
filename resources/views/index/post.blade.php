@extends('base')

@section('canonical_tag')
    <link rel="canonical" href="{{ config('app.url') . '/' . $row->lang_code .'/post/' . $row->slug }}" />
@endsection

@section('title', $title)

@section('meta_keywords', str_replace('+', ',', $row->meta_keywords))
@section('meta_description', $row->meta_description)

@section('content')
<div>
    @include('index.common_header')
        
    <div class="row">
        <div class="col-12 markdown-body" dir="auto">
            @if ($row->author_note)
                <div class="admonition note pb-1">
                    <p class="admonition-title">{{ __("Author note") }}</p>
                        <p class="pt-1">{{ $row->author_note }}</p>
                </div>                        
            @endif
            
            @if ($row->story)
                <div class="admonition attention">
                    <p class="admonition-title">{{ __("Story") }}: {{ $row->story->name }}</p>
                    <p> {{ __("In this story") }}</p>
                    <ol>
                        @foreach ($row->story->posts()->where('active', true)->get() as $post)
                            <li>
                                @if ($post->id == $row->id)
                                    {{ $post->title }} ({{ __("This post") }})
                                @else
                                    <a href="{{ route('post', ['lang_code' => $post->lang_code, 'post' => $post]) }}">{{ $post->title }}</a></li>                           
                                @endif                                    
                        @endforeach
                    </ol>
                </div>                    
            @endif
            
            @if ($row->body_html)
                {!! $row->body_html !!}
            @else
                {{ $row->body }}
            @endif
        </div>
    </div>
    
    <div class="row g-0 mt-5 p-3 border rounded">
        <div class="col-3">
            <img src="{{ $row->author->avatar() }}" class="rounded-circle img-fluid">
        </div>

        <div class="col-9 ps-3">
            <p class="h4"> {{ $row->author->name }} </p>

            {!! $row->author->about_html ?? "" !!}
        </div>
    </div>

    <div class="row"  id="comments">
        <div class="col-12 text-end mt-5 mb-3">
            <a class="btn btn-outline-primary btn-sm" href="#comments">
                {{ $row->comments()->where('active', true)->count() }} {{ __('Comments') }}
            </a>
        </div>    
    </div>   
    
    @include('index.recursive_comments', 
        ['comments' => $row->comments()->whereNull('parent_id')->where('active', true)->get()])
    
    
    @if ($row->get_comment)
    <div class="row" dir="auto">
        <div class="col-12">
            <p class="mt-5 text-secondary" id="comment_form"> {{ __('Leave a comment.') }} </p>
            <div id="form_info"></div>
        </div>
    </div>           
    
    <form method="post" action="{{ route('store_comment', ['post' => $row]) }}" class="form mb-3" role="form">
    @csrf
    {!! form_row($commentForm->parent_id) !!}

    <div class="row" dir="auto">
        @guest
            <div class="mb-3 col-6">                
                {!! form_row($commentForm->name) !!}
            </div>
            
            <div class="mb-3 col-6">
                {!! form_row($commentForm->email) !!}
            </div>                 
        @endguest
        
        <div class="mb-3 col-12">
            {!! form_row($commentForm->comment) !!}
        </div>
        
        <div class="mb-3 col">
            {!! form_row($commentForm->submit) !!}
        </div>        
    </div>
    </form>
    @endif
</div>    
@endsection

@section('scripts')
    @parent
    
    <script>
    function responseTo(post_id, comment) {
        document.getElementById('parent_id').value=post_id;
        document.getElementById('form_info').innerHTML="> " + comment;
        //document.getElementById('comment').focus();   
    }
    </script>
@endsection