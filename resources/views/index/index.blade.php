@extends("base")

@section('title', $title)

@section("content")

@if (isset($tag) || isset($author))
    <div class="alert alert-primary h3" dir=auto>
        @if (isset($tag))
            {{-- Tag page --}}
            @section('canonical_tag')
                <link rel="canonical" href="{{ config('app.url') . '/' . $tag->lang_code .'/tag/' . $tag->name }}" />
            @endsection

            @if (auth()->user()?->isAdministrator())
                <a href="{{ route('admin.tags.change_iwt_status', ['tag' => $tag]) }}" title="{{ $tag->integrated_with_template ? __('Remove tag from template') : __('Add tag to template') }}">
                    {{ $tag->integrated_with_template ? '+' : '-' }}
                </a>
            @endif
            {{ __("Tag") }}: {{ $tag->name }}

        @elseif (isset($author))
            {{-- Author page --}}
            @section('canonical_tag')
                <link rel="canonical" href="{{ config('app.url') . '/' . $langCode->name .'/author/' . $author->name }}" />
            @endsection
            {{ __("Posts of") }} : {{ $author->name }}
        @endif
    </div>
@else
    {{-- home page --}}
    @section('canonical_tag')
        <link rel="canonical" href="{{ config('app.url') }}" />
    @endsection
@endif

@forelse ($rows as $row)
    <div class="mb-3 @if (! $loop->last) border-bottom @endif">
            
        
            @include('index.common_header')

            <div class="row">     
                <div class="col-12 markdown-body" dir="auto">               
                        @if ($row->resume_html)
                            {!! $row->resume_html !!}
                        @else
                            {{ $row->resume }}
                        @endif                            
                </div>
            </div>    
          
            <div class="row mt-4 mb-3"> 
                <div class="col text-end">
                    <div class="btn-group">                    
                        <a href="{{ route('post', ['langCode' => $row->lang_code, 'post' => $row->slug]) }}" class="btn btn-outline-danger btn-sm">{{ __('Continue reading this post') }}</a>
                        <a href="{{ route('post', ['langCode' => $row->lang_code, 'post' => $row->slug]) }}#comments" 
                            class="btn btn-sm btn-outline-primary">
                                @php
                                $commentCount = $row->comments()->where('active', true)->count();
                                @endphp

                                {{ trans_choice('Comment|Comments', $commentCount) }} {{ $commentCount }}
                        </a>                
                    </div>                        
                </div>                           
            </div>
            
                                                  
        </div> 
@empty
    <h1> {{ __('No records found.') }}
@endforelse

@endsection
