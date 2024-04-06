@extends("base")

@section("content")

@forelse ($rows as $row)
    @if ($loop->first)
        <table class="table table-responsive">
            <thead>
                <tr>
                    <td> # </td>
                    <td> {{ __('Title') }} </td>
                    <td> </td>                                 
                </tr>
            </thead>

            <tbody>
    @endif

    <tr>
        <td> {{ $loop->iteration }} </td>
        <td> 
            <a href="{{ route('admin.posts.edit', ['post' => $row]) }}">{{ $row->title }}</a>            
        </td>

        <td class="text-end">
            @if ($row->locked)
                <span class="badge bg-warning">{{ __('locked') }}</span>
            @endif

            @if (! $row->active)            
                <span class="badge bg-danger"> {{__('Inactive')    }} </span>
            @endif

            @if ( !$row->show_in_list)
                <span class="badge bg-info"> {{  __('Not in list') }} </span>
            @endif

            @php
            $commentCount = $row->comments()->count();
            @endphp
            
            @if ($commentCount)
                <span class="badge bg-success">
                    <a href="{{ route('admin.comments.index', ['post' => $row]) }}">            
                        {{ $row->comments()->count() }} {{ __('Comments') }}
                    </a>
                </span>
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