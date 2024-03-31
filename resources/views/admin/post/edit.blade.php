@extends("base")

@section("content")

{!! form($form) !!}

{{--
<form action="{{ route('admin.posts.update', ['post' => $row]) }}" method="post">
    @csrf
    @method('patch')

    <div class="row">
        <div class="col-md-4 align-self-end"> {!! form_row($form->get_comment) !!} </div>
        <div class="col-md-4 align-self-end"> {!! form_row($form->active) !!} </div>
        <div class="col-md-4 align-self-end"> {!! form_row($form->show_in_list) !!} </div>       
        <div class="col-md-6 align-self-end"> {!! form_row($form->title) !!} </div>
        <div class="col-md-6"> {!! form_row($form->slug) !!} </div>
        <div class="col-12 align-self-end"> {!! form_row($form->resume) !!} </div>
        <div class="col-12 align-self-end"> {!! form_row($form->body) !!} </div>
        <div class="col-md-6 align-self-end"> {!! form_row($form->meta_keywords) !!} </div>
        <div class="col-md-6 align-self-end"> {!! form_row($form->meta_description) !!} </div>
        <div class="col-md-6 align-self-end"> {!! form_row($form->tags) !!} </div>
        <div class="col-md-6 align-self-end"> {!! form_row($form->story_id) !!} </div>
        <div class="col-12 align-self-end"> {!! form_row($form->author_note) !!} </div>
        <div class="col-12 align-self-end"> {!! form_row($form->submit) !!} </div>
    </div>
</form>
--}}

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