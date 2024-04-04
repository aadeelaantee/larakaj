@extends("base")

@section("content")

@forelse ($rows as $row)
    @if ($loop->first)
        <table class="table table-responsive">
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
        <td> <a href="{{ route('admin.stories.edit', ['story' => $row]) }}">{{ $row->name }}</a></td>
        
        <td class="text-end">
            <span class="badge bg-warning">{{ $row->posts()->count() }} {{ __('Posts') }}</span>
            {{-- <span class="ps-1"><a href="{{ route('admin.stories.edit', ['story' => $row]) }}">🖉</a></span> --}}
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
