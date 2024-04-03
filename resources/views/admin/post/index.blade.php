@extends("base")

@section("content")

@forelse ($rows as $row)
    @if ($loop->first)
        <table class="table">
            <thead>
                <tr>
                    <td> # </td>
                    <td> {{ __('Title') }} </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>                                   
                </tr>
            </thead>

            <tbody>
    @endif

    <tr>
        <td> {{ $loop->iteration }} </td>
        <td> 
            <a href="{{ route('admin.posts.edit', ['post' => $row]) }}">{{ $row->title }}</a>
            @if ($row->locked)
                <span class="badge bg-warning">{{ __('locked') }}</span>
            @endif
        </td>
        <td> {{ $row->active       ? __('Active')  : __('Inactive')    }} </td>
        <td> {{ $row->show_in_list ? __('In list') : __('Not in list') }}</td>
        <td> 
            @php
            $commentCount = $row->comments()->count();
            @endphp
            
            @if ($commentCount)
                <a href="{{ route('admin.comments.index', ['post' => $row]) }}">
            @endif

            {{ $row->comments()->count() }} {{ __('Comments') }}

            @if ($commentCount)
                </a>
            @endif
        </td>
    </tr>

    @if ($loop->last)
            </tbody>
        </table>
    @endif

@empty
    <h1> No records </h1>
@endforelse

@endsection