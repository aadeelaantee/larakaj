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
                    <td colspan="2" class="text-end">
                        <a href="" class="btn btn-sm btn-primary">{{ __('New post') }}</a>
                    </td>                    
                </tr>
            </thead>

            <tbody>
    @endif

    <tr>
        <td> {{ $loop->iteration }} </td>
        <td> {{ $row->title }} </td>
        <td> {{ $row->lang_code }} </td>
        <td> {{ $row->active       ? __('Active')  : __('Inactive')    }} </td>
        <td> {{ $row->show_in_list ? __('In list') : __('Not in list') }}</td>
        <td> {{ $row->comments()->count() }} {{ __('Comments') }} </td>
        <td> <a href="{{ route('admin.posts.edit', ['post' => $row]) }}">🖉</a></td>
    </tr>

    @if ($loop->last)
            </tbody>
        </table>
    @endif

@empty
    <h1> No records </h1>
@endforelse

@endsection