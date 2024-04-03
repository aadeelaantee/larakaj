<html lang="{{ $langCode->name }}" @if ($langCode->rtl) dir="rtl" @endif>
    <head>
        <title>
        {{ config('app.name') }}
        @hasSection('title')
            - @yield('title')
        @endif
        </title>

        @section('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css">

        @if ($langCode->rtl)
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">
            <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
            <link href="{{ asset('static/css/fa.css') }}" type="text/css" rel="stylesheet" >
            <link href="{{ asset('static/css/admonition_fa.css') }}" type="text/css" rel="stylesheet">
        @else
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

            <link href="{{ asset('static/css/admonition.css') }}" type="text/css" rel="stylesheet">
        @endif

        <link href="{{ asset('static/css/main.css') }}" type="text/css" rel="stylesheet">
        <link href="{{ asset('static/css/github-markdown-light.css') }}" type="text/css" rel="stylesheet" >
        <link href="{{ asset('static/css/codehilite.css') }}" type="text/css" rel="stylesheet" >
        <link href="{{ asset('static/css/keys.css') }}" type="text/css" rel="stylesheet">

        

        
        <link rel="icon" type="image/x-icon" href="{{ asset('static/icons/favicon.png') }}">
        @show        
    </head>

    <body>

        <nav @class([
            'navbar navbar-expand-lg navbar-light bg-light',
        ])>
          <div class="container-fluid">
            <a href="{{ route('root') }}"><img src="{{ asset('/static/icons/favicon.png') }}" alt="" height="36" class="border-0 me-1"></a>
            <a class="navbar-brand" href="{{ route('root') }}">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                
                @foreach (\App\Models\LangCode::all() as $langCode_)
                    <li class="nav-item">
                      <a @class([
                            "nav-link",
                            "active fw-bold" => isset($langCode) && $langCode_->name == $langCode->name,
                        ]) aria-current="page" href="{{ route('home', ['langCode' => $langCode_]) }}">{{ ucfirst($langCode_->name) }}</a>
                    </li>                
                @endforeach

                @php
                $routeName = request()->route()->getName();
                $hasSideBar = in_array($routeName, [
                    'root',
                    'home',
                    'tag',
                    'profile',
                    'edit_profile',
                    'author',
                    'post',
                ]) ? true : false;
                @endphp

                @auth
                    @if (request()->user()->isAdministrator())
                        <li class="nav-item">
                          <a @class(['nav-link', 
                                'active fw-bold' => in_array($routeName, [
                                    'admin.posts.index',
                                    'admin.posts.create',
                                    'admin.posts.edit',
                                ]),
                            ])
                            
                            aria-current="page" href="{{ route('admin.posts.index') }}">{{ __('Posts') }}</a>
                        </li>
                        
                        <li class="nav-item">
                          <a @class([
                                'nav-link', 
                                'active fw-bold' => in_array($routeName, [
                                    'admin.stories.index',
                                    'admin.stories.edit',
                                ]),
                            ]) aria-current="page" href="{{ route('admin.stories.index') }}">{{ __('Stories') }}</a>
                        </li>
                        
                         <li class="nav-item">
                          <a @class([
                                "nav-link",
                                'active fw-bold' => $routeName == 'admin.comments.index',
                            ]) aria-current="page" href="{{ route('admin.comments.index') }}">{{ __('Comments') }}</a>
                        </li>
                        
                        <li class="nav-item">
                          <a @class([
                                "nav-link",
                                'active fw-bold' => in_array($routeName, [
                                    'admin.ldmanager.index',
                                    'admin.ldmanager.category',
                                    'admin.ldmanager.edit_link',
                                    'admin.ldmanager.edit_category',
                                ]),
                            ])  aria-current="page" href="{{ route('admin.ldmanager.index') }}">{{ __('Linkdumps') }}</a>
                        </li>
                        
                        <li class="nav-item">
                          <a @class([
                                "nav-link",
                                'active fw-bold' => in_array($routeName, [
                                    'admin.lang_codes.index',
                                    'admin.lang_codes.edit',
                                ]),
                            ])  aria-current="page" href="{{ route('admin.lang_codes.index') }}">{{ __('Lang codes') }}</a>
                        </li>

                        <li class="nav-item">
                          <a @class([
                                "nav-link",
                                'active fw-bold' => in_array($routeName, [
                                    'admin.users.index',
                                    'admin.users.edit'
                                ]),
                            ]) aria-current="page" href="{{ route('admin.users.index') }}">{{ __('Users') }}</a>
                        </li>
                    @endif
                        <li class="nav-item">
                          <a class="nav-link" aria-current="page" href="{{ route('logout') }}">{{ __('Logout') }}</a>
                        </li>                                           
                @else
                    <li class="nav-item">
                      <a @class([
                            "nav-link",
                            'active fw-bold' => $routeName == 'login',
                        ]) aria-current="page" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                      <a @class([
                            "nav-link",
                            'active fw-bold' => $routeName == 'register',
                        ])  href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endauth

                <!--
                <li class="nav-item">
                  <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
                -->
                
              </ul>
              <!--
              <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
              </form>
              -->
            </div>
          </div>
        </nav>

        <br>
        
        
        

        <div class="container">

            <div class="row">
                <div @class([
                        "col-lg-9" => $hasSideBar,
                        "col-lg-12" => ! $hasSideBar,
                    ])
                    
             id="main-content">
                    {{-- user defined flashed messages --}}
                    @session('messages')                
                        @foreach($value as $message)
                            @php
                            $category = null;
                            if (count($message) == 2) {
                                $category = $message[0];
                                $text = $message[1];
                            }
                            else
                                $text = $message[0];
                            @endphp

                            <div class="alert alert-{{ $category ?? 'info' }}">{{ $text }}</div>                
                        @endforeach
                    @endsession

                    <div class="row">
                        <div class="col-12">

                            @if (Route::is('admin.*'))
                                <div class="row mb-3">
                                    <div class="text-start col-md-4 h4 text-muted">{{ $title ?? "" }}</div>
                                    <div class="text-end col-md-8">
                                        @if (isset($navigation))
                                            @foreach ($navigation as $nav)
                                                <a href="{!! $nav[1] !!}" class="btn btn-sm btn-primary">
                                                    {{ $nav[0] }}
                                                </a>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @section("content")
                            @show
                        </div>            
                    </div>        
                </div>
                
                @if ($hasSideBar)
                
                <div class="col-lg-3" id="side-bar">
                
                    <div class="card mb-3">
                        <div class="card-header">{{ __("Authors") }}</div>
                        <div class="card-body text-center">
                            
                            @foreach (\App\Models\User::where('active', true)->whereHas('posts')->get() as $author_)

                            <div class="btn-group mb-1 w-100">
                                <a @class([
                                        'btn btn-outline-primary btn-sm',
                                        'active' => isset($author) && $author_->is($author),
                                    ]) href="{{ route('author', ['user' => $author_]) }}">{{ $author_->name }} <span class="badge bg-danger">{{ $author_->posts()->count() }}</span></a>                                
                                <a  @class([
                                        "btn btn-outline-primary btn-sm",
                                        "active" => $routeName == 'profile' && isset($user) && $author_->is($user),
                                    ]) href="{{ route('profile', ['user' => $author_]) }}">{{ __('Profile') }}</a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    
                    @foreach (\App\Models\LinkdumpCategory::whereIntegratedWithTemplate(true)->whereLangCode($langCode->name)->get() as $category)
                        @if ($category->links()->count())
                            <div class="card mb-3">
                                <div class="card-header">{{ $category->name }}</div>
                                <div class="card-body rtl">
                                                        
                                @foreach ($category->links as $link)
                                    @if ($loop->first)
                                        <div class="w-100 btn-group-vertical">
                                    @endif
                                    <a class="btn btn-outline-primary btn-sm"  title="{{ $link->alt }}" href="{{ $link->link }}">{{ $link->text }} </a>
                                    
                                    @if ($loop->last)
                                        </div>
                                    @endif
                                @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                    
                    
                    <div class="card mb-3">
                        <div class="card-header">{{ __("Tags") }}</div>
                        <div class="card-body rtl">
                            @foreach (\App\Models\Tag::whereHas('posts', function ($s) use ($langCode) { $s->where('lang_code', $langCode->name); })->get() as $tag_)
                                <a @class([
                                        'btn btn-sm btn-outline-primary mb-1',
                                        'active' => isset($tag) && $tag_->is($tag)
                                    ])  href="{{ route('tag', ['tag' => $tag_]) }}">
                                        {{ $tag_->name }} <b>{{ $tag_->posts()->whereActive(true)->whereLangCode($langCode->name)->count()}}</b>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>                                                            
         </div>


        @section('footer')
            @if ($hasSideBar)
                <div class="mt-5 container-fluid  pt-3">
                    @include('index.linkdumps')
                </div>
            @endif                           
            <footer class="mt-5 p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                {{ __('All right reserved for') }} <a href="{{ route('home') }}">{{ config('app.name') }}</a> &copy;2024</footer>                
        @show  
        

        @section('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
        <script>hljs.highlightAll();</script>
        @show


            



            
        </div>
    </body>
</html>
