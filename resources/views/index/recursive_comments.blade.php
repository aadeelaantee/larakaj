    @foreach ($comments as $comment)
        @if ($loop->depth == 1 & $loop->first)
            <div class="row" dir="auto">
        @endif


            <div  class="col-{{ 12 - $loop->depth - 1 }} offset-{{ $loop->depth - 1 }}">
                <div class="row">
                    <div class="col-1">
                    <img class="img-fluid" src="{{-- comment.avatar(128) --}}">
                     </div>
                    <div class="col-11">
                        <span class="badge bg-warning">
                        @if ($comment->author)
                            <a href="{{ url_for('user.index.profile', ['lang_code' => 'fa', 'username' => $comment->author->username]) }}">
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
                        
        @if ($loop->depth == 1 && $loop->last) </div> @endif   
    @endforeach