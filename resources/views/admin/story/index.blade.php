@extends("base")

@section("content")

@forelse ($rows as $row)
    @if ($loop->first)
        <table class="table">
            <thead>
                <tr>
                    <td> # </td>
                    <td> {{ __('Name') }} </td>
                    <td> </td>
                </tr>
            </thead>

            <tbody>
    @endif

    <tr>
        <td> {{ $loop->iteration }} </td>
        <td> {{ $row->name }} </td>
        
        <td class="text-end">
            <div class="row">
                <div class="col-9 text-end">
                    @if (! $row->posts()->count())
                        <form  method="post" action="{{ route('admin.stories.destroy', ['story' => $row]) }}">
                        @csrf
                        @method('delete')
                        <input type="submit" value="{{ __('Delete') }}" class="btn btn-sm btn-outline-danger">
                        </form>
                    @endif
                </div>

                <div class="col-3">
                    <span class="badge bg-warning">{{ $row->posts()->count() }} {{ __('Posts') }}</span>
                    <span class="ps-1"><a href="{{ route('admin.stories.edit', ['story' => $row]) }}">🖉</a></span>
                </div>
            </div>
        </td>
    </tr>

    @if ($loop->last)
            </tbody>
        </table>
    @endif

@empty
    <h1> No records </h1>
@endforelse

<div class="mt-5">
    {!! form($form) !!}
</div>

@endsection
