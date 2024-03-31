@extends("base")

@section("content")

@forelse ($rows as $row)
    @if ($loop->first)
        <table class="table text-center">
            <thead>
                <tr>
                    <td> # </td>
                    <td> {{ __('Username') }} </td>
                    <td> {{ __('Name') }} </td>
                    <td> {{ __('Email') }} </td>
                    <td> {{ __('Status') }} </td>
                    <td> {{ __('Created at') }}</td>
                    <td> </td>
                </tr>
            </thead>

            <tbody>
    @endif

    <tr>
        <td> {{ $loop->iteration }} </td>
        <td> {{ $row->username }} </td>
        <td> {{ $row->name }} </td>
        <td> {{ $row->email }}</td>
        <td> {{ $row->active ? __('Active') : __('Inactive') }} </td>
        <td dir="ltr"> {{ $row->created_at }}</td>
        <td> <a href="{{ route('admin.users.edit', ['user' => $row]) }}">🖉</a></td>
    </tr>

    @if ($loop->last)
            </tbody>
        </table>
    @endif

@empty
    <h1> No records </h1>
@endif

@endsection
