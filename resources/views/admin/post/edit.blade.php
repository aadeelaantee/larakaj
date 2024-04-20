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


<div class="mt-5">
    <p class="mb-3"> {{ __('Drop files here for upload.') }} </p>
    <form action="{{ route('admin.posts.upload_files', ['post' =>$row]) }}" class="dropzone" id="dropzone">@csrf</form>
</div>

@endsection


{{-- section style --}}
@section('styles')
@parent
<style>
.dropzone .dz-image img {
    width: 120px;
    height: 120px;
}
</style>
@endsection
{{-- end section style --}}



{{-- section scripts --}}
@section("scripts")
@parent
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

<script>
Dropzone.options.dropzone = {  
    init: function () {
        var mockFile;
        
        @foreach ($row->files as $file)
            mockFile = { 
                name: '{{ '/storage/' . $file->path }}',
                type: '{{ \Illuminate\Support\Facades\File::mimeType(storage_path('app/public/'. $file->path)) }}',
                url: '{{ '/storage/' . $file->path }}',
                status: this.ADDED,
                accepted: true,
                size: {{ \Illuminate\Support\Facades\Storage::size('public/'. $file->path) }}
            };
                
            this.emit("addedfile", mockFile);
            this.emit("thumbnail", mockFile, '{{ asset("/storage/" . $file->path) }}');
            this.emit("complete", mockFile);
            this.files.push(mockFile);
        @endforeach
    }
};
</script>
@endsection
{{-- end section scripts --}}