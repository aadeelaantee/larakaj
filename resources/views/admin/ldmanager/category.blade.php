@extends('base')

@section('title', $title)

@section('content')


@forelse ($rows as $row)
    @if ($loop->first)
        <table class="table mb-5  table-responsive">
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
        <td> <a href="{{ $row->link }}" alt="{{ $row->alt }}" title="{{ $row->alt }}">{{ $row->text }}</a></td>
        <td class="text-end">
            <span> <a href="{{ route('admin.ldmanager.edit_link', ['ldLink' => $row]) }}">🖉</a> </span>
            <span> <a href="{{ route('admin.ldmanager.destroy_link', ['ldLink' => $row]) }}">🗑</a> </span>
        </td>
    </tr>

    @if ($loop->last)
            </tbody>
        </table>
    @endif

@empty

@endforelse



{!! form($form) !!}

@if (! count($rows))
    <div class="text-end">
        <form method="post" action="{{ route('admin.ldmanager.destroy_category', ['ldCategory' => $category]) }}">
        @method("delete")
        @csrf

        <input type="submit" class="btn btn-danger" value="{{ __('Delete this category.') }}">
        </form>
    </div>
@endif
@endsection