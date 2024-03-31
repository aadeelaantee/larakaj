    @foreach ($comments as $comment)

            <div  class="col-{{ 14 - $loop->depth - 1 }} offset-{{ $loop->depth - 1 }}">
                <div class="text-start row">
                    <div class="text-start col-1">
                        <img class="img-fluid" src="{{ $comment->author?->avatar(128) ?? $comment->avatar(128) }}">
                     </div>
                    <div class="col-11">
                        <span class="badge bg-warning">
                        @if ($comment->author)
                            <a href="{{ route('profile', ['user' => $comment->author]) }}">
                                {{ $comment->author->name }}
                            </a>
                        @else                
                            {{ $comment->name }} 
                        @endif
                        </span>
                        
                        <a href="#{{ $comment->id }}"><span class="badge bg-secondary" id="{{ $comment->id }}">{{ $comment->date_created }}</span></a>                        
                        
                        <p class="mt-2"> {{ $comment->comment }} <a href="#comment_form" onclick="responseTo({{ $comment->id }}, '{{ $comment->comment }}')">{{ __("Response") }}</a> <p>               
                    </div>                
                </div>
            </div>  
              
            @if ($comment->children)
                @include('index.recursive_comments', ['comments' => $comment->children])
            @endif
        
    @endforeach