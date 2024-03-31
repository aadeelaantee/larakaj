@extends('base')

@section('title', $title)

@section('content')

<div class="text-end"> 
    <a href="{{ route('admin.ldmanager.index') }}" class="btn btn-sm btn-primary">{{ __('Ldmanager') }}</a>
</div>

{!! form($form) !!}
@endsection