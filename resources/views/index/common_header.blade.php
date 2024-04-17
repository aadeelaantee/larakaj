            <div class="row">
                <div class="col-12">
                    <p dir="auto" class="h4 mb-4">                
                            <a href="{{ route('post', ['langCode' => $row->lang_code, 'post' => $row]) }}">
                                {{ $row->title }}
                            </a>
                    </p>
                </div>
            </div>
            
            
            <div class="row">    
                <div class="col-12 text-secondary post-info-line">
                    <p dir="auto">
                        {{ __('Posted by') }}:
                            <span class="badge bg-warning">
                                <a href="{{ route('profile', ['langCode' => $row->lang_code, 'user' => $row->author->username]) }}">                                
                                {{ $row->author->name }}
                                </a>     
                            </span>
                         {{ __('on') }} <span class="badge bg-danger">{{ $row->created_at->diffForHumans() }}</span>
                        
                        @foreach ($row->tags as $tag)
                            @if ($loop->first)
                                {{ __('under') }}
                            @endif
                            
                            <a href="{{ route('tag', ['langCode' => $row->lang_code, 'tag' => $tag->name]) }}"><span class="badge bg-primary">{{ $tag->name }}</span></a>
                        @endforeach 
                        
                        @auth
                            <a href="{{ route('admin.posts.edit', ['post' => $row]) }}"><span class="badge bg-primary">{{ __('Edit') }}</span></a>
                        @endauth
                    </p>
                </div>
            </div>
