@extends('base')

@section('title', $title)

@section('content')

{!! form($form) !!}

@forelse ($rows as $row)
    @if ($loop->first)
        <table class="table">
            <thead>
                <tr>
                    <td> # </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                </tr>
            </thead>

            <tbody> 
    @endif

    <tr>
        <td> {{ $loop->iteration }} </td>
        <td> {{ $row->name }} </td>
        <td> 
            @if ($row->default)
                <span class="badge bg-primary"> {{ __('default') }} </span>
            @endif

            @if ($row->rtl)
                <span class="badge bg-danger">rtl</span>
            @endif

        </td>
        <td class="text-end"> 
            <a href="{{ route('admin.lang_codes.edit', ['lc' => $row]) }}">🖉</a>
        </td>
    </tr>

    @if ($loop->last)
            </tbody>  
        </table>
    @endif
@empty
    <h1> {{__('No records.') }} </h1>
@endforelse

@endsection