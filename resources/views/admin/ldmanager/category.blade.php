@extends('base')

@section('title', $title)

@section('content')


<div class="text-center">
<span class="badge bg-warning fs-2">{{ $category->name }}</span>
</div>

@forelse ($rows as $row)
    @if ($loop->first)
        <table class="table mb-5">
            <thead>
                <tr>
                    <td> # </td>
                    <td> {{ __('Title') }} </td>
                    <td class="text-end"> 
                        <a href="{{ route('admin.ldmanager.index') }}" class="btn btn-sm btn-primary">{{ __('Ldmanager') }}</a>

                    </td>
                </tr>
            </thead>

            <tbody>
    @endif

    <tr>
        <td> {{ $loop->iteration }} </td>
        <td> <a href="{{ $row->link }}" alt="{{ $row->alt }}" title="{{ $row->alt }}">{{ $row->text }}</a></td>
        <td>
            <span> <a href="{{ route('admin.ldmanager.edit_link', ['ldLink' => $row]) }}">🖉</a> </span>
            <span> <a href="{{ route('admin.ldmanager.destroy_link', ['ldLink' => $row]) }}">🗑</a> </span>
        </td>
    </tr>

    @if ($loop->last)
            </tbody>
        </table>
    @endif

@empty
    <h3> {{ __('No records found') }} </h3>
@endforelse



{!! form($form) !!}

@endsection