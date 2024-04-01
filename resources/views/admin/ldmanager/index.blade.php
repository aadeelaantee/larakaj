@extends("base")

@section("content")

{!! form($form) !!}
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
        <td> <a href="{{ route('admin.ldmanager.category', ['ldCategory' => $row]) }}"> {{ $row->name }} </a> </td>
        <td>
            <span> <a href="{{ route('admin.ldmanager.edit_category', ['ldCategory' => $row]) }}">🖉</a></span>
            <span class="badge bg-warning">{{ $row->links()->count() }} {{ trans_choice('link|links', $row->links()->count() ) }} </a> </span>
            @if ($row->integrated_with_template)
                <span class="badge bg-danger">{{ __('Integrated with template') }}</span>
            @endif
        </td>
    </tr>

    @if ($loop->last)
            </tbody>
        </table>
    @endif

@empty
    <h3> {{ __('No records found') }} </h3>
@endforelse

@endsection
